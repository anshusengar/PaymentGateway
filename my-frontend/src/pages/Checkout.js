import { useParams, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import API from "../api";
import { useLocation } from "react-router-dom";

export default function Checkout() {
  const { id } = useParams();
  const navigate = useNavigate();

  const [product, setProduct] = useState(null);
  const [availableCoupons, setAvailableCoupons] = useState([]);
  const [couponCode, setCouponCode] = useState('');
  const [discount, setDiscount] = useState(0);
  const [finalPrice, setFinalPrice] = useState(null);
  const [couponMessage, setCouponMessage] = useState('');
const location = useLocation();
const queryParams = new URLSearchParams(location.search);
const selectedSize = queryParams.get("size");


  const [address, setAddress] = useState({
    name: "",
    phone: "",
    pincode: "",
    street: "",
    city: "",
    state: "",
  });

  useEffect(() => {
    API.get(`/products/${id}`)
      .then((res) => setProduct(res.data.data || res.data))
      .catch((err) => console.error("Error loading product", err));

    API.get('/available-coupons')
      .then(res => setAvailableCoupons(res.data))
      .catch(err => console.error('Error loading coupons', err));
  }, [id]);

  const handleChange = (e) => {
    setAddress({
      ...address,
      [e.target.name]: e.target.value,
    });
  };

 const applyCoupon = async (code) => {
  try {
    const actualTotal = finalPrice || product.price;

    console.log({
      coupon_code: code,
      cart_total: actualTotal,
      payment_method: 'razorpay',
      products: [{ id: product.id }],
    });

    const res = await API.post('/check-coupon', {
      coupon_code: code,
      cart_total: actualTotal,
      payment_method: 'razorpay',
      products: [{ id: product.id }],
    });

    if (res.data.success === true) {
      setCouponCode(code);
      setDiscount(res.data.discount);
      setFinalPrice(res.data.new_total);
      setCouponMessage(res.data.message);
    } else {
      setDiscount(0);
      setFinalPrice(null);
      setCouponCode('');
      setCouponMessage(res.data.message);
    }
  } catch (err) {
    console.error(err);
    setCouponMessage('Error validating coupon');
  }
};

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!address.name || !address.phone || !address.pincode) {
      alert("Please fill in all required fields");
      return;
    }

    try {
     const orderResponse = await API.post("/orders", {
  product_id: product.id,
  qty: 1,
  size: selectedSize || null,
  address: address.street,
  phone: address.phone,
  pincode: address.pincode,
  city: address.city,
  state: address.state,
  price: finalPrice || product.price,
  status: "pending",
   coupon_code: couponCode || null,
});
      const orderId = orderResponse.data.id;

      const razorpayOrder = await API.post("/create-razorpay-order", {
        order_id: orderId,
      });

      const options = {
        key: razorpayOrder.data.razorpay_key,
        amount: (finalPrice || product.price) * 100,
        currency: razorpayOrder.data.currency,
        name: "MyClothingStore",
        description: product.name,
        order_id: razorpayOrder.data.order_id,
        handler: function (response) {
          API.post("/payment", {
            razorpay_order_id: response.razorpay_order_id,
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_signature: response.razorpay_signature,
          })
            .then(() => {
              alert("✅ Payment successful!");
              navigate("/");
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
      console.error(err);
      alert("Something went wrong during checkout.");
    }
  };

  if (!product) {
    return <p className="text-center mt-8">Loading product details...</p>;
  }

  return (
    <div className="max-w-2xl mx-auto p-4">
      <h2 className="text-2xl font-bold mb-4">Checkout</h2>

     <div className="border p-4 mb-4 rounded shadow text-center">
  <h3 className="font-semibold mb-2">{product.name}</h3>
  <img
    src={`http://127.0.0.1:8000/storage/${product.image}`}
    alt={product.name}
    className="w-32 h-32 object-cover mx-auto mb-2"
  />
  <div className="text-sm text-gray-600 space-y-1">
    {product.brand && <p><strong>Brand:</strong> {product.brand}</p>}
    {product.category && <p><strong>Category:</strong> {product.category}</p>}
    {selectedSize && <p><strong>Size:</strong> {selectedSize}</p>}
    {product.sku && <p><strong>SKU:</strong> {product.sku}</p>}
    {product.color && <p><strong>Color:</strong> {product.color}</p>}
  </div>
  <p className="text-lg font-medium mt-2">
    Price:{" "}
    {discount > 0 ? (
      <>
        <span className="line-through text-gray-500 mr-2">₹{product.price}</span>
        <span className="text-green-600">₹{finalPrice}</span>
      </>
    ) : (
      <>₹{product.price}</>
    )}
  </p>
</div>


      {/* Coupon Section */}
      {/* Coupon Section */}
<div className="border p-4 rounded shadow mb-4">
  <h3 className="font-semibold mb-2">Available Coupons</h3>

  {availableCoupons.length > 0 ? (
    availableCoupons.map((coupon) => {
      const actualTotal = finalPrice ?? product.price ?? 0;
      const isDisabled = actualTotal < (coupon.min_order_amount ?? 0);

      return (
        <div
          key={coupon.code}
          className="flex justify-between items-center p-2 border-b"
        >
          <div>
            <p className={`font-semibold ${isDisabled ? 'text-gray-400' : ''}`}>
              {coupon.code}
            </p>
            <p className="text-sm text-gray-600">{coupon.description}</p>
            {isDisabled && (
              <p className="text-xs text-red-500">
                Min order ₹{coupon.min_order_amount} required
              </p>
            )}
          </div>
          <button
            disabled={isDisabled}
            onClick={() => applyCoupon(coupon.code)}
            className={`text-sm px-3 py-1 rounded transition ${
              isDisabled
                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                : 'bg-green-600 text-white hover:bg-green-700'
            }`}
          >
            Apply
          </button>
        </div>
      );
    })
  ) : (
    <p className="text-sm text-gray-500">No available coupons</p>
  )}

  {couponCode && (
    <div className="mt-4 bg-green-50 border border-green-400 p-2 rounded flex justify-between items-center">
      <p className="text-green-700 text-sm">
        Applied <strong>{couponCode}</strong> - You saved ₹{discount}
      </p>
      <button
        onClick={() => {
          setCouponCode('');
          setDiscount(0);
          setFinalPrice(null);
          setCouponMessage('');
        }}
        className="text-sm text-red-500 underline"
      >
        Remove
      </button>
    </div>
  )}

  {couponMessage && (
    <p className="text-sm mt-2 font-medium text-green-600">{couponMessage}</p>
  )}
</div>


      {/* Address Form */}
      <form onSubmit={handleSubmit} className="space-y-4">
        <input
          type="text"
          name="name"
          placeholder="Full Name"
          value={address.name}
          onChange={handleChange}
          className="border p-2 rounded w-full"
          required
        />
        <input
          type="text"
          name="phone"
          placeholder="Phone"
          value={address.phone}
          onChange={handleChange}
          className="border p-2 rounded w-full"
          required
        />
        <input
          type="text"
          name="pincode"
          placeholder="Pincode"
          value={address.pincode}
          onChange={handleChange}
          className="border p-2 rounded w-full"
          required
        />
        <input
          type="text"
          name="street"
          placeholder="Street Address"
          value={address.street}
          onChange={handleChange}
          className="border p-2 rounded w-full"
        />
        <input
          type="text"
          name="city"
          placeholder="City"
          value={address.city}
          onChange={handleChange}
          className="border p-2 rounded w-full"
        />
        <input
          type="text"
          name="state"
          placeholder="State"
          value={address.state}
          onChange={handleChange}
          className="border p-2 rounded w-full"
        />
        <button
          type="submit"
          className="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition"
        >
          Continue to Pay
        </button>
      </form>
    </div>
  );
}
