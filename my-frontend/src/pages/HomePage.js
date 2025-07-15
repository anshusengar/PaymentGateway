import { useContext } from "react";
import { useQuery } from "@tanstack/react-query";
import { CartContext } from "../context/CartContext";
import { WishlistContext } from "../context/WishlistContext";
import API from "../api";
import Footer from "../components/Footer";
import { Link } from "react-router-dom";
import ProductSkeletonCard from "../components/ProductSkeletonCard";
import ProductCard from "../components/ProductCard";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";

export default function HomePage() {
  const { addToCart } = useContext(CartContext);
  const { addToWishlist, removeFromWishlist, isInWishlist } = useContext(WishlistContext);

  const fetchHomepageData = async () => {
    const categoryRes = await API.get("/categories");
    const categories = categoryRes.data;

    const productsByCategory = {};
    await Promise.all(
      categories.map(async (cat) => {
        try {
          const productRes = await API.get(`/products?category_id=${cat.id}`);
          productsByCategory[cat.id] = productRes.data;
        } catch {
          productsByCategory[cat.id] = [];
        }
      })
    );

    return { categories, productsByCategory };
  };

  const { data, isLoading, isError } = useQuery({
    queryKey: ["homepageData"],
    queryFn: fetchHomepageData,
    staleTime: 2 * 60 * 1000,
    refetchInterval: 5 * 60 * 1000,
    refetchOnWindowFocus: true,
  });

  if (isLoading) {
    return (
      <div className="flex gap-4 flex-wrap p-8 justify-center">
        {[...Array(8)].map((_, idx) => (
          <ProductSkeletonCard key={idx} />
        ))}
      </div>
    );
  }

  if (isError) {
    return <p className="text-center py-10 text-red-500">Error loading data</p>;
  }

  const { categories, productsByCategory } = data;

  return (
    <main>
      {/* Hero Section */}
      <section className="relative w-full h-[400px] md:h-[500px]">
        <img
          loading="lazy"
          src="/slide.jpg"
          alt="Fashion Banner"
          className="absolute inset-0 w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-black bg-opacity-40"></div>
        <div className="absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Welcome to MyClothingStore
          </h1>
          <p className="text-lg mb-4">Shop the latest trends in fashion</p>
          <button className="px-6 py-2 bg-[#FFD700] text-slate-800 font-semibold rounded hover:bg-yellow-400 transition">
            Shop Now
          </button>
        </div>
      </section>

      {/* Category wise products */}
      <section className="py-16 bg-white">
        <div className="px-4">
          {categories.map((cat) => (
            <div key={cat.id} className="mb-12">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-3xl font-bold text-slate-800">{cat.name}</h2>
                <Link to={`/category/${cat.id}`} className="text-indigo-600 text-sm hover:underline">
                  See All →
                </Link>
              </div>

              {productsByCategory[cat.id]?.length > 0 ? (
                <Swiper
                  spaceBetween={16}
                  slidesPerView={1.2}
                  breakpoints={{
                    640: { slidesPerView: 2.2 },
                    768: { slidesPerView: 3.2 },
                    1024: { slidesPerView: 4.2 },
                  }}
                >
                  {productsByCategory[cat.id].map((product) => (
                    <SwiperSlide key={product.id}>
                      <ProductCard
                        product={product}
                        isWishlisted={isInWishlist(product.id)}
                        onToggleWishlist={(p) =>
                          isInWishlist(p.id)
                            ? removeFromWishlist(p.id)
                            : addToWishlist(p)
                        }
                        onAddToCart={addToCart}
                      />
                    </SwiperSlide>
                  ))}
                </Swiper>
              ) : (
                <p className="text-gray-500">No products found in this category.</p>
              )}
            </div>
          ))}
        </div>
      </section>

      <Footer />
    </main>
  );
}
