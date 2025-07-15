import { useEffect, useState, useContext } from "react";
import { useParams, useNavigate } from "react-router-dom";
import API from "../api";
import { WishlistContext } from "../context/WishlistContext";
import { FaStar, FaStarHalfAlt, FaRegStar } from "react-icons/fa";

export default function ProductDetail() {
  const { id } = useParams();
  const [product, setProduct] = useState(null);
  const [user, setUser] = useState(null);
  const navigate = useNavigate();
const [selectedRating, setSelectedRating] = useState("");
const [comment, setComment] = useState("");
  const { addToWishlist, removeFromWishlist, isInWishlist } = useContext(WishlistContext);
const [selectedImage, setSelectedImage] = useState("");
const [selectedSize, setSelectedSize] = useState("");

useEffect(() => {
  API.get(`/products/${id}`).then((res) => {
    setProduct(res.data);
    if (res.data.images && res.data.images.length > 0) {
      // ✅ get the full image path
      setSelectedImage(`http://127.0.0.1:8000/storage/${res.data.images[0].image_path}`);
    } else {
      // fallback
      setSelectedImage(`http://127.0.0.1:8000/storage/${res.data.image}`);
    }
  });
}, [id]);


  useEffect(() => {
    API.get("/user")
      .then((res) => setUser(res.data))
      .catch(() => setUser(null));
  }, []);

  const handleBuyNow = () => {
  if (!user) {
    alert("Please login first to buy products.");
    return;
  }

  if (product.sizes && product.sizes.length > 0 && !selectedSize) {
    alert("❌ Please select a size before proceeding.");
    return;
  }

  navigate(`/checkout/${product.id}?size=${selectedSize}`);
};
  if (!product) {
    return <p className="text-center mt-10">Loading product...</p>;
  }

  // Calculate original price if not present
  const originalPrice = product.original_price
    ? product.original_price
    : product.discount > 0
    ? (product.price / (1 - product.discount / 100)).toFixed(0)
    : null;

const rawRating = product.rating || 0;
const rating = typeof rawRating === "number" ? rawRating : parseFloat(rawRating) || 0;


const handleSubmitReview = () => {
  if (!selectedRating) {
    alert("Please select a rating");
    return;
  }

  API.post("/reviews", {
    product_id: product.id,
    rating: selectedRating,
    comment,
  })
    .then(() => {
      alert("Thank you for your review!");
      setSelectedRating("");
      setComment("");
    })
    .catch(() => alert("Something went wrong"));
};

  return (
    <div className="max-w-7xl mx-auto px-6 py-12">
      <div className="grid grid-cols-1 md:grid-cols-12 gap-10">
        {/* Product Image */}
        <div className="md:col-span-5 self-start bg-white p-6 border rounded-lg shadow-sm">
  <div className="flex flex-col md:flex-row items-start gap-4">
  {/* Thumbnails */}
  <div className="flex md:flex-col gap-2">
    
   {product.images?.map((img, index) => (
  <img
    key={index}
    src={`http://127.0.0.1:8000/storage/${img.image_path}`}
    onClick={() => setSelectedImage(`http://127.0.0.1:8000/storage/${img.image_path}`)}
    className={`w-16 h-16 object-cover rounded cursor-pointer border-2 ${
      selectedImage === `http://127.0.0.1:8000/storage/${img.image_path}` ? "border-pink-600" : "border-gray-300"
    }`}
  />
))}
  </div>

  {/* Main Image (Selected) */}
  <div className="flex-1">
    <img
      src={selectedImage}
      alt="Selected"
      className="w-full max-w-md aspect-square object-cover rounded-lg shadow-lg transition-transform duration-300"
    />
  </div>
</div>

</div>

        {/* Product Info */}
        <div className="md:col-span-7">
          <h2 className="text-3xl font-bold text-slate-800 mb-2">{product.name}</h2>
          <p className="text-gray-600 text-sm mb-1">{product.brand || "Kaprakriti"}</p>

          {/* ⭐ Ratings */}
        <div className="flex items-center mt-2 gap-1">
  {Array.from({ length: 5 }).map((_, i) => {
    const filled = i + 1 <= Math.floor(rating);
    const half = i + 1 - rating < 1 && i + 1 > rating;

    return (
      <span key={i} className="text-yellow-500">
        {filled ? <FaStar /> : half ? <FaStarHalfAlt /> : <FaRegStar />}
      </span>
    );
  })}
  <span className="text-sm text-gray-600 ml-2">
    {rating.toFixed(1)} / 5 ({product.review_count} reviews)
  </span>
</div>



          {/* Pricing */}
          <div className="flex items-center space-x-4 mt-4 mb-4">
            <span className="text-3xl font-semibold text-indigo-600">₹{product.price}</span>
            {originalPrice && (
              <span className="line-through text-gray-400 text-lg">₹{originalPrice}</span>
            )}
            {product.discount > 0 && (
              <span className="text-green-600 font-medium">{product.discount}% OFF</span>
            )}
          </div>

          {/* Description */}
          <div className="mt-6 space-y-6">
            <div>
              <h3 className="text-lg font-semibold mb-2">Description</h3>
              <p className="text-gray-700 leading-relaxed">
                {product.description ||
                  "This is a high-quality product built with premium materials. Perfect for daily use and stylish too."}
              </p>
            </div>

            {/* Sizes */}
            {product.sizes && product.sizes.length > 0 && (
              <div>
                <h3 className="text-lg font-semibold mb-2">Available Sizes</h3>
                <div className="flex gap-2 flex-wrap">
                 {product.sizes && product.sizes.length > 0 && (
  <div>
    <h3 className="text-lg font-semibold mb-2">Available Sizes</h3>
    <div className="flex gap-2 flex-wrap">
      {product.sizes.map((size, index) => (
        <button
          key={index}
          type="button"
          onClick={() => setSelectedSize(size)}
          className={`px-3 py-1 border rounded text-sm transition ${
            selectedSize === size
              ? "bg-pink-600 text-white border-pink-600"
              : "bg-gray-100 text-gray-700"
          }`}
        >
          {size}
        </button>
      ))}
    </div>
  </div>
)}

                </div>
              </div>
              
            )}
          

          </div>
 
          {/* Buttons */}
          {/* Buttons */}
<div className="mt-8 flex flex-col md:flex-row gap-4">
  <button
    onClick={handleBuyNow}
    className="w-full md:w-1/2 bg-pink-600 hover:bg-pink-700 transition text-white text-lg px-4 py-2 rounded font-semibold shadow-sm"
  >
    Buy Now
  </button>

  <button
    onClick={() =>
      isInWishlist(product.id)
        ? removeFromWishlist(product.id)
        : addToWishlist(product)
    }
    className="w-full md:w-1/2 border border-pink-600 text-pink-600 hover:bg-pink-50 transition text-lg px-4 py-2 rounded font-semibold shadow-sm"
  >
    {isInWishlist(product.id) ? "❤️ Remove from Wishlist" : "🤍 Add to Wishlist"}
  </button>
</div>

{/* 💬 Review Submission Form */}
{user && (
  <div className="mt-12 border-t pt-8">
    <h3 className="text-xl font-bold text-slate-800 mb-4">Leave a Review</h3>
    <div className="space-y-3">
      <div className="flex gap-4 items-center">
        <label className="font-medium text-gray-700">Your Rating:</label>
        <select
          value={selectedRating}
          onChange={(e) => setSelectedRating(e.target.value)}
          className="border border-gray-300 px-3 py-1 rounded text-sm"
        >
          <option value="">Select</option>
          {[1, 2, 3, 4, 5].map((r) => (
            <option key={r} value={r}>{r} Star{r > 1 && "s"}</option>
          ))}
        </select>
      </div>

      <textarea
        value={comment}
        onChange={(e) => setComment(e.target.value)}
        className="w-full border border-gray-300 px-3 py-2 rounded text-sm"
        rows={4}
        placeholder="Write your review..."
      />

      <button
        onClick={handleSubmitReview}
        className="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 transition text-sm font-semibold"
      >
        Submit Review
      </button>
    </div>
  </div>
)}


{/* 💬 Reviews Section */}
<div className="mt-12">
  <h3 className="text-xl font-bold text-slate-800 mb-4">Customer Reviews</h3>

  {product.reviews && product.reviews.length > 0 ? (
    <div className="space-y-4">
      {product.reviews.map((review) => (
        <div key={review.id} className="border rounded p-4 shadow-sm">
          <div className="flex justify-between items-center mb-2">
            <strong>{review.user?.name || "User"}</strong>
            <div className="text-yellow-500">
              {"⭐".repeat(review.rating)}{"☆".repeat(5 - review.rating)}
            </div>
          </div>
          <p className="text-gray-700">{review.comment}</p>
        </div>
      ))}
    </div>
  ) : (
    <p className="text-gray-500">No reviews yet.</p>
  )}
</div>

          </div>
        </div>
      </div>
  );
}
