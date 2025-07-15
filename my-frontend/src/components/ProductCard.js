// ProductCard.js
import { Link } from "react-router-dom";
import { Heart, Heart as HeartFilled } from "lucide-react";

export default function ProductCard({ product, isWishlisted, onToggleWishlist, onAddToCart }) {
  const rating = Number(product.rating) || 0;

  return (
    <div className="w-[220px] flex-shrink-0 border border-gray-200 rounded-lg p-2 hover:shadow-md transition relative">
      <Link to={`/product/${product.id}`}>
        <div className="w-full h-[280px] bg-gray-100 rounded overflow-hidden">
          <img
            loading="lazy"
            src={`http://127.0.0.1:8000/storage/${product.image}`}
            alt={product.name}
            className="w-full h-full object-cover"
          />
        </div>
      </Link>

      {product.discount > 0 && (
        <div className="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded">
          {product.discount}% OFF
        </div>
      )}

      <button
        onClick={() => onToggleWishlist(product)}
        className="absolute top-2 right-2 z-10 bg-white rounded-full p-1 border border-gray-300"
        title={isWishlisted ? "Remove from Wishlist" : "Add to Wishlist"}
      >
        {isWishlisted ? (
          <HeartFilled className="text-red-500 w-5 h-5" />
        ) : (
          <Heart className="text-gray-400 w-5 h-5" />
        )}
      </button>

      <div className="mt-2">
        <h4 className="text-base font-medium text-gray-800 truncate">{product.name}</h4>
        <div className="flex items-center gap-0.5 text-yellow-500 text-sm mt-1">
          {[...Array(5)].map((_, idx) => (
            <span key={idx}>{idx < rating ? "★" : "☆"}</span>
          ))}
        </div>
        <p className="text-sm text-gray-500 mt-1 line-clamp-2">
          {product.description.length > 50 ? product.description.slice(0, 50) + "..." : product.description}
        </p>

        {product.sizes && product.sizes.length > 0 && (
          <div className="flex flex-wrap gap-1 text-xs text-gray-600 mb-1">
            {product.sizes.map((size, idx) => (
              <span key={idx} className="px-2 py-1 border rounded text-gray-700 bg-gray-100">
                {size}
              </span>
            ))}
          </div>
        )}

        <p className="text-lg font-semibold text-gray-800 mt-1">₹{product.price}</p>
        <button
          onClick={() => onAddToCart(product)}
          className="w-full mt-3 bg-pink-600 text-white hover:bg-pink-700 font-medium py-2 rounded"
        >
          Add to Cart
        </button>
      </div>
    </div>
  );
}
