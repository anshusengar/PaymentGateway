import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import API from "../api";

export default function Home() {
  const [products, setProducts] = useState([]);
   const [user, setUser] = useState(null);

  const navigate = useNavigate();

  useEffect(() => {
  API.get("/user")
    .then((res) => setUser(res.data.name))
    .catch(() => setUser(null));
}, []);
  useEffect(() => {
    API.get("/products")
      .then((res) => setProducts(res.data.data || res.data))
      .catch((err) => console.error("Error loading products", err));
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("token");
    setUser(null);
    navigate("/login");
  };

  return (
    <div className="bg-gray-50 min-h-screen">
      {/* Navbar */}
      <nav className="bg-white shadow py-4 px-8 flex justify-between items-center">
        <div className="text-xl font-bold text-blue-700">MyStore</div>
       
        <div className="space-x-4">
          <button
            className="text-gray-700 hover:text-blue-700"
            onClick={() => navigate("/about")}
          >
            About Us
          </button>
          <button
            className="text-gray-700 hover:text-blue-700"
            onClick={() => navigate("/contact")}
          >
            Contact Us
          </button>
          {!user ? (
            <>
              <button
                className="text-gray-700 hover:text-blue-700"
                onClick={() => navigate("/login")}
              >
                Login
              </button>
              <button
                className="text-gray-700 hover:text-blue-700"
                onClick={() => navigate("/register")}
              >
                Register
              </button>
            </>
          ) : (
            <>
              <span className="text-gray-700 font-medium">{user}</span>
              <button
                className="text-gray-700 hover:text-red-600"
                onClick={handleLogout}
              >
                Logout
              </button>
            </>
          )}
        </div>
      </nav>

      {/* Hero Banner */}
      <section className="bg-blue-600 text-white text-center py-16">
        <h2 className="text-5xl font-bold mb-2">Welcome to MyStore</h2>
        <p className="text-xl">Discover your style. Shop the trends.</p>
      </section>

      {/* Featured Products */}
      <section className="max-w-6xl mx-auto py-10 px-4">
        <h3 className="text-2xl font-semibold mb-6">Featured Products</h3>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          {products.length ? (
            products.map((prod) => (
              <div
                key={prod.id}
                className="bg-white shadow rounded p-4 flex flex-col items-center"
              >
                <img
                  src={`http://127.0.0.1:8000/storage/${prod.image}`}
                  alt={prod.name}
                  className="w-32 h-32 object-cover rounded"
                />
                <h4 className="mt-4 text-lg font-medium">{prod.name}</h4>
                <p className="text-gray-700">₹{prod.price}</p>
               <button
  className="mt-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500"
  onClick={() => navigate(`/product/${prod.id}`)}
>
  Buy Now
</button>
              </div>
            ))
          ) : (
            <p>Loading products...</p>
          )}
        </div>
      </section>
    </div>
  );
}
