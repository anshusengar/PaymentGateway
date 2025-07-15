import { useContext,useState } from "react";
import { CartContext } from "../context/CartContext";
import { Link } from "react-router-dom";

export default function CartPage() {

  const [cart, setCart] = useState(null);
  const { cartItems, increaseQty, decreaseQty, removeFromCart } =
    useContext(CartContext);


    
  const total = cartItems.reduce((sum, item) => sum + item.price * item.qty, 0);

  return (
    <div className="max-w-4xl mx-auto p-4">
      <h2 className="text-2xl font-bold mb-6">Shopping Cart</h2>

      {cartItems.length === 0 ? (
        <p>Your cart is empty.</p>
      ) : (
        cartItems.map((item) => (
          <div key={item.id} className="flex items-center gap-4 mb-6 border-b pb-4">
            <img
              src={`http://127.0.0.1:8000/storage/${item.image}`}
              className="w-32 h-32 object-cover rounded"
              alt={item.name}
            />
            <div className="flex-1">
              <h4 className="font-semibold">{item.name}</h4>
              <div className="flex items-center gap-2 mt-2">
                <button
                  onClick={() => decreaseQty(item.id)}
                  className="px-2 py-1 border rounded bg-gray-100 hover:bg-gray-200"
                >
                  -
                </button>
                <span>{item.qty}</span>
                <button
                  onClick={() => increaseQty(item.id)}
                  className="px-2 py-1 border rounded bg-gray-100 hover:bg-gray-200"
                >
                  +
                </button>
              </div>
              <p className="mt-2">₹{item.price * item.qty}</p>
            </div>
            <button
              onClick={() => removeFromCart(item.id)}
              className="text-red-600 hover:underline"
            >
              Remove
            </button>
          </div>
        ))
      )}

      {cartItems.length > 0 && (
        <div className="text-right font-semibold text-lg">
          Total: ₹{total}
        </div>
      )}
       <div className="text-right">
            <Link
             to={`/checkout/${cart[0].id}`}
              className="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition"
            >
              Proceed to Checkout
            </Link>
          </div>
    </div>
  );
}
