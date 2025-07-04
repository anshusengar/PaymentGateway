import Footer from "../components/Footer";
import { useEffect, useState } from "react";
import API from "../api";
import { Link } from "react-router-dom";

export default function HomePage() {

  const [products, setProducts] = useState([]);


     useEffect(() => {
    API.get("/products")
      .then((res) => setProducts(res.data.data || res.data))
      .catch((err) => console.error("Error loading products", err));
  }, []);

  return (
    <main className="">
      <section className="relative w-full h-[400px] md:h-[500px]">
        {/* Background image */}
        <img
          src="/slide.jpg"
          alt="Fashion Banner"
          className="absolute inset-0 w-full h-full object-cover"
        />

        {/* optional dark overlay for better text readability */}
        <div className="absolute inset-0 bg-black bg-opacity-40"></div>

        {/* text ON the image */}
        <div className="absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">Welcome to MyClothingStore</h1>
          <p className="text-lg mb-4">Shop the latest trends in fashion</p>
          <button className="px-6 py-2 bg-indigo-600 rounded hover:bg-indigo-700 transition">
            Shop Now
          </button>
        </div>
      </section>


<section className="py-12 bg-white">
  <div className="container mx-auto px-4">
    <h2 className="text-3xl font-bold text-center mb-8">Featured Products</h2>
    <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    {products.map((product) => (
  <div
    key={product.id}
    className="border rounded-lg shadow hover:shadow-xl transition relative overflow-hidden"
  >
    {/* Product Image */}
   <Link to={`/product/${product.id}`}>
  <img
    src={`http://127.0.0.1:8000/storage/${product.image}`}
    alt={product.name}
    className="w-full h-80 object-cover hover:scale-105 transition"
  />
</Link>

    {/* Info */}
    <div className="p-3 text-left">
      <h4 className="font-semibold text-gray-800">{product.brand}</h4>
      <p className="text-gray-600 text-lg">{product.name}</p>
      <div className="mt-1 flex items-center gap-2">
        <span className="font-bold text-indigo-600">₹{product.price}</span>
        {product.discount > 0 && (
          <span className="text-green-600 text-xs">
            {product.discount}% OFF
          </span>
        )}
      </div>
     
    </div>
  </div>
))}


    </div>
  </div>
</section>




      <Footer />
    </main>
  );
}
