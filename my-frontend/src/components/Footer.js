import { FaFacebook, FaInstagram, FaTwitter } from "react-icons/fa";

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-gray-300 mt-10">
      <div className="container mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-8">
        {/* About */}
        <div>
          <h3 className="text-lg font-semibold mb-2 text-white">MyClothingStore</h3>
          <p className="text-sm">
            Bringing you the latest styles and trends at affordable prices.
          </p>
        </div>
        {/* Links */}
        <div>
          <h3 className="text-lg font-semibold mb-2 text-white">Quick Links</h3>
          <ul className="text-sm space-y-1">
            <li><a href="/" className="hover:text-indigo-400">Home</a></li>
            <li><a href="/shop" className="hover:text-indigo-400">Shop</a></li>
            <li><a href="/contact" className="hover:text-indigo-400">Contact</a></li>
            <li><a href="/about" className="hover:text-indigo-400">About Us</a></li>
          </ul>
        </div>
        {/* Social */}
        <div>
          <h3 className="text-lg font-semibold mb-2 text-white">Follow Us</h3>
         <div className="flex space-x-4">
  <a href="https://facebook.com" target="_blank" rel="noreferrer" className="hover:text-indigo-400">
    <FaFacebook size={20} />
  </a>
  <a href="https://instagram.com" target="_blank" rel="noreferrer" className="hover:text-indigo-400">
    <FaInstagram size={20} />
  </a>
  <a href="https://twitter.com" target="_blank" rel="noreferrer" className="hover:text-indigo-400">
    <FaTwitter size={20} />
  </a>
</div>

        </div>
      </div>
      <div className="bg-gray-800 text-center text-sm py-3">
        &copy; {new Date().getFullYear()} MyClothingStore. All rights reserved.
      </div>
    </footer>
  );
}
