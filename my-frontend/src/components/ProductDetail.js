import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import API from "../api";

export default function ProductDetail() {
  const { id } = useParams();
  const [product, setProduct] = useState(null);
  const [user, setUser] = useState(null);

  // fetch product
  useEffect(() => {
    API.get(`/products/${id}`)
      .then((res) => setProduct(res.data.data || res.data))
      .catch((err) => console.error("Error loading product", err));
  }, [id]);

  // fetch user
  useEffect(() => {
    API.get("/user")
      .then((res) => setUser(res.data.id)) // store full user object
      .catch(() => setUser(null));
  }, []);

  const handleBuyNow = async () => {
    try {
      if (!product) {
        alert("Product data is not loaded yet.");
        return;
      }
      if (!user) {
        alert("Please login first to buy products.");
        return;
      }

      // 1️⃣ create a local order
     const orderResponse = await API.post("/orders", {
  product_id: product.id,
  qty: 1,
  userid: user.id,         // ✅ send the user ID
  price: product.price,    // ✅ product price
  status: "pending",       // ✅ status as a string
});


      const orderId = orderResponse.data.id;

      // 2️⃣ create Razorpay order
      const razorpayOrder = await API.post("/create-razorpay-order", {
        order_id: orderId,
      });

      const options = {
        key: razorpayOrder.data.razorpay_key,
        amount: razorpayOrder.data.amount,
        currency: razorpayOrder.data.currency,
        name: "MyStore",
        description: product.name,
        order_id: razorpayOrder.data.order_id,
        handler: function (response) {
          API.post("/payment", {
            razorpay_order_id: response.razorpay_order_id,
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_signature: response.razorpay_signature,
          })
            .then(() => {
              alert("✅ Payment successful and verified!");
            })
            .catch(() => {
              alert("⚠️ Payment verification failed");
            });
        },
        theme: { color: "#3399cc" },
      };

      const rzp = new window.Razorpay(options);
      rzp.open();
    } catch (err) {
      console.error("Error during payment flow:", err);
      alert("Something went wrong, please try again.");
    }
  };

  // safeguard for *both* product and user
  if (!product) {
    return <p className="text-center mt-10">Loading product...</p>;
  }

  return (
    <div className="max-w-xl mx-auto p-4">
      <h2 className="text-3xl font-bold mb-2">{product.name}</h2>
      <img
        src={`http://127.0.0.1:8000/storage/${product.image}`}
        alt={product.name}
        className="w-64 h-64 object-cover mb-4"
      />
      <p className="text-xl font-semibold mb-4">₹{product.price}</p>
      <button
        className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500"
        onClick={handleBuyNow}
      >
        Pay Now
      </button>
    </div>
  );
}
