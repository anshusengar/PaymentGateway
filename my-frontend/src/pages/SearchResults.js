import { useSearchParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import API from "../api";
import ProductSkeletonCard from "../components/ProductSkeletonCard"; // ✅ Import this

export default function SearchResults() {
  const [params] = useSearchParams();
  const query = params.get("query") || "";

  const {
    data: products = [],
    isLoading,
    isError,
  } = useQuery({
    queryKey: ["searchProducts", query],
    queryFn: async () => {
      const res = await API.get(`/products?search=${query}`);
      return res.data;
    },
    enabled: !!query, // only fetch if query is not empty
  });

  return (
    <div className="container mx-auto px-4 py-8">
      <h2 className="text-2xl font-semibold text-slate-800 mb-6">
        Search results for:{" "}
        <span className="text-indigo-600">"{query}"</span>
      </h2>

      {isLoading ? (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          {[...Array(8)].map((_, idx) => (
            <ProductSkeletonCard key={idx} />
          ))}
        </div>
      ) : isError ? (
        <p className="text-red-500 text-center">Error loading results</p>
      ) : products.length > 0 ? (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          {products.map((prod) => (
            <div
              key={prod.id}
              className="border rounded p-4 shadow hover:shadow-lg transition"
            >
              <img
                src={`http://127.0.0.1:8000/storage/${prod.image}`}
                alt={prod.name}
                className="w-full h-[250px] object-cover rounded mb-2"
              />
              <h3 className="font-semibold">{prod.name}</h3>
              <p>₹{prod.price}</p>
            </div>
          ))}
        </div>
      ) : (
        <p>No products found.</p>
      )}
    </div>
  );
}
