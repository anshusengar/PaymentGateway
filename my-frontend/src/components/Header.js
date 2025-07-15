import { Link } from "react-router-dom";
import { FaShoppingCart } from "react-icons/fa";
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { useCart } from "../context/CartContext";
import { WishlistContext } from "../context/WishlistContext";
import { Heart } from "lucide-react";
import { useContext } from "react";

export default function Header({ user, onLogout }) {
  const { wishlist } = useContext(WishlistContext);
  const [dropdownOpen, setDropdownOpen] = useState(false);
const [searchTerm, setSearchTerm] = useState("");
  const navigate = useNavigate();
const { cartItems } = useCart();
  return (
    <header className="bg-white shadow sticky top-0 z-50">
      <div className="container mx-auto flex justify-between items-center px-4 py-3">
        {/* Logo */}
        <Link to="/" className="text-2xl font-bold text-indigo-700 tracking-wide">
          MyClothingStore
        </Link>

        {/* Navigation */}
        <nav className="hidden md:flex space-x-8 font-medium text-gray-700">
          <Link
            to="/"
            className="hover:text-indigo-600 transition"
          >
            Home
          </Link>
          <Link
            to="/shop"
            className="hover:text-indigo-600 transition"
          >
            Shop
          </Link>
          <Link to="/cart" className="text-indigo-600 hover:underline">
Cart
</Link>
          <Link
            to="/contact"
            className="hover:text-indigo-600 transition"
          >
            Contact
          </Link>
        </nav>


 <div className="flex items-center space-x-4 relative">
  {/* Search */}
  <div className="hidden md:block">
    <input
      type="text"
      placeholder="Search for products"
      aria-label="Search products"
      className="border rounded px-3 py-1"
      value={searchTerm}
      onChange={(e) => setSearchTerm(e.target.value)}
      onKeyDown={(e) => {
        if (e.key === "Enter") {
          const trimmed = searchTerm.trim();
          if (trimmed) {
            navigate(`/search?query=${encodeURIComponent(trimmed)}`);
          }
        }
      }}
    />
  </div>


  {/* Cart */}
  <Link to="/cart" className="relative hover:text-indigo-600 transition">
    <FaShoppingCart size={22} />
  <span className="absolute -top-2 -right-2 text-xs bg-red-500 text-white rounded-full px-1">
    {cartItems.length}
    </span>
  </Link>
 <Link to="/wishlist" className="relative">
          <Heart className="w-6 h-6 text-gray-700 hover:text-red-500" />
          {wishlist.length > 0 && (
            <span className="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
              {wishlist.length}
            </span>
          )}
        </Link>
  {/* User / Auth */}
  {user ? (
    <div className="relative">
      <button
        onClick={() => setDropdownOpen(!dropdownOpen)}
        className="text-gray-700 hover:text-indigo-600 transition font-medium"
      >
        {user.name}
      </button>
      {dropdownOpen && (
        <div className="absolute right-0 mt-2 w-40 bg-white border rounded shadow">
          <Link
            to="/profile"
            className="block px-4 py-2 hover:bg-gray-100"
          >
            Profile
          </Link>
           <Link
            to="/my-orders"
            className="block px-4 py-2 hover:bg-gray-100"
          >
            My Orders
          </Link>
          <button
            onClick={() => {
              onLogout();
              setDropdownOpen(false);
            }}
            className="w-full text-left px-4 py-2 hover:bg-gray-100"
          >
            Logout
          </button>
        </div>
      )}
    </div>
  ) : (
    <>
      <Link
        to="/login"
        className="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
      >
        Login
      </Link>
      <Link
        to="/register"
        className="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 transition"
      >
        Register
      </Link>
    </>
  )}
</div>

      </div>
    </header>
  );
}
