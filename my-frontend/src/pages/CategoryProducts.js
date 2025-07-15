import { useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import API from "../api";
import { Link } from "react-router-dom";
import { useContext } from "react";
import { CartContext } from "../context/CartContext";

export default function CategoryProducts() {
  const { id } = useParams();
  const [products, setProducts] = useState([]);
  const [category, setCategory] = useState(null);
  const { addToCart } = useContext(CartContext);

  useEffect(() => {
    API.get(`/products?category_id=${id}`).then((res) =>
      setProducts(res.data)
    );
    API.get(`/categories`).then((res) => {
      const cat = res.data.find((c) => c.id == id);
      setCategory(cat);
    });
  }, [id]);

  return (
    <div className="container mx-auto px-4 py-10">
      <h2 className="text-3xl font-bold text-slate-800 mb-8">
        {category?.name || "Category"} Products
      </h2>

      {products.length > 0 ? (
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {products.map((product) => (
            <div key={product.id} className="border rounded shadow p-2">
              <Link to={`/product/${product.id}`}>
                <img
                  src={`http://127.0.0.1:8000/storage/${product.image}`}
                  alt={product.name}
                  className="w-full h-[250px] object-cover rounded"
                />
              </Link>
              <h4 className="font-semibold mt-2">{product.name}</h4>
              <p className="text-gray-500 text-sm">
                {product.description.slice(0, 50)}...
              </p>
              <p className="text-gray-700 mt-1">₹{product.price}</p>
              <button
                onClick={() => addToCart(product)}
                className="w-full mt-2 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
              >
                Add to Cart
              </button>
            </div>
          ))}
        </div>
      ) : (
        <p className="text-gray-500">No products found in this category.</p>
      )}
    </div>
  );
}
