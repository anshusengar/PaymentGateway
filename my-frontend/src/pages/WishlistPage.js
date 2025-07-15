// src/pages/WishlistPage.js
import { useContext } from "react";
import { WishlistContext } from "../context/WishlistContext";
import { Link } from "react-router-dom";

export default function WishlistPage() {
  const { wishlist, removeFromWishlist } = useContext(WishlistContext);

  return (
    <div className="container mx-auto px-4 py-8">
      <h2 className="text-2xl font-bold mb-6">Your Wishlist</h2>

      {wishlist.length === 0 ? (
        <p>No items in wishlist.</p>
      ) : (
        <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
          {wishlist.map((product) => (
            <div key={product.id} className="border p-4 rounded shadow">
              <Link to={`/product/${product.id}`}>
                <img
                  src={`http://127.0.0.1:8000/storage/${product.image}`}
                  alt={product.name}
                  className="w-full h-[200px] object-cover mb-2"
                />
                <h4 className="font-semibold">{product.name}</h4>
                <p className="text-gray-700">₹{product.price}</p>
              </Link>
              <button
                onClick={() => removeFromWishlist(product.id)}
                className="mt-2 text-sm text-red-500 hover:underline"
              >
                Remove
              </button>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
