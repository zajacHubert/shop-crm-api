<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;

class OrderService implements OrderServiceInterface
{
    private Order $orderModel;
    private ProductRepositoryInterface $productRepository;
    private OrderItem $orderItem;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        Order $orderModel,
        ProductRepositoryInterface $productRepository,
        OrderItem $orderItem,
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->orderModel = $orderModel;
        $this->productRepository = $productRepository;
        $this->orderItem = $orderItem;
        $this->orderRepository = $orderRepository;
    }

    public function store(Request $request): Response
    {
        $order = new $this->orderModel();
        $order->id = Str::uuid()->toString();
        $order->user_id = auth()->user()->id;
        $order->value = 0;
        $order->save();

        $products = $request->input('products', []);

        try {
            $totalAmount = 0;
            foreach ($products as $product) {
                $found = $this->productRepository->show($product['id']);
                if (!$found) {
                    throw new \Exception("Product not found.");
                }

                $orderItem = new $this->orderItem();
                $orderItem->id = Str::uuid()->toString();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $found->id;
                $orderItem->quantity = $product['quantity'];
                $orderItem->price = $found->price;
                $orderItem->save();

                $totalAmount += $found->price * $product['quantity'];
            }
            $order->value = $totalAmount;
            $order->save();

            DB::commit();

            $order->load('user', 'orderItems.product');

            return response(new OrderResource($order), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): Response
    {
        $success = $this->orderModel::destroy($id);

        return response([
            'isSuccess' => boolval($success),
        ]);
    }

    public function processPayment(Request $request): Response
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $products = $request->input('products', []);

            $paymentIntent = PaymentIntent::create([
                'amount' => $this->calculateOrderAmount($products) * 100,
                'currency' => 'eur',
                'payment_method_types' => ['card', 'p24'],
            ]);
            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (CardException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function calculateOrderAmount(array $products): float
    {
        $totalAmount = 0;

        foreach ($products as $product) {
            $found = $this->productRepository->show($product['id']);
            if (!$found) {
                throw new \Exception("Product not found.");
            }
            $totalAmount += $found->price * $product['quantity'];
        }

        return $totalAmount;
    }
}
