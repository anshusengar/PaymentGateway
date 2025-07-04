import { Link } from "react-router-dom";
import { FaShoppingCart } from "react-icons/fa";
import { useState } from "react";

export default function Header({ user, onLogout }) {
  const [dropdownOpen, setDropdownOpen] = useState(false);

  return (
    <header className="bg-white shadow sticky top-0 z-50">
      <div className="container mx-auto flex justify-between items-center px-4 py-3">
        {/* Logo */}
        <Link to="/" className="text-2xl font-bold text-indigo-700 tracking-wide">
          MyClothingStore
        </Link>

        {/* Navigation */}
        <nav className="hidden md:flex space-x-6 font-medium text-gray-700">
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
          <Link
            to="/contact"
            className="hover:text-indigo-600 transition"
          >
            Contact
          </Link>
        </nav>

        {/* Right section */}
        <div className="flex items-center space-x-4 relative">
          {/* Cart */}
          <Link to="/cart" className="relative hover:text-indigo-600 transition">
            <FaShoppingCart size={22} />
            <span className="absolute -top-2 -right-2 text-xs bg-red-500 text-white rounded-full px-1">
              2
            </span>
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
