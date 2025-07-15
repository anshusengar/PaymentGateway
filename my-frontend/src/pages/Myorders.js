import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import API from "../api";

export default function MyOrders() {
  const [orders, setOrders] = useState([]);
  const [showRating, setShowRating] = useState(false);
  const [selectedOrder, setSelectedOrder] = useState(null);
  const [rating, setRating] = useState(0);
  const [comment, setComment] = useState("");

  useEffect(() => {
    API.get("/my-orders")
      .then((res) => setOrders(res.data))
      .catch((err) => console.error("Error loading orders", err));
  }, []);

  const retryPayment = async (order) => {
    const razorpayOrder = await API.post("/create-razorpay-order", {
      order_id: order.id,
    });

    const options = {
      key: razorpayOrder.data.razorpay_key,
      amount: order.price * 100,
      order_id: razorpayOrder.data.order_id,
      handler: function (response) {
        API.post("/payment", response)
          .then(() => {
            alert("✅ Payment success");
            window.location.reload();
          })
          .catch(() => alert("❌ Payment failed"));
      },
    };

    const rzp = new window.Razorpay(options);
    rzp.open();
  };

  const getStatusLabel = (status, created_at) => {
    if (status === "delivered") {
      const today = new Date().toLocaleDateString();
      const deliveredDate = new Date(created_at).toLocaleDateString();
      return today === deliveredDate ? "Delivered Today" : "Delivered";
    }
    if (status === "out_for_delivery") return "Out for Delivery";
    if (status === "shipped") return "Shipped";
    if (status === "paid") return "Ordered";
    return "Pending";
  };

  const getProgressSteps = (status) => {
    const steps = ["Ordered", "Shipped", "OFD", "Delivered"];
    const statusMap = {
      paid: 0,
      shipped: 1,
      out_for_delivery: 2,
      delivered: 3,
    };
    const currentIndex = statusMap[status] ?? 0;

    return steps.map((label, index) => ({
      label,
      completed: index <= currentIndex,
    }));
  };

  const handleCancel = async (id) => {
    try {
      const res = await API.post(`/orders/${id}/cancel`);
      alert(res.data.message);
      window.location.reload();
    } catch {
      alert("❌ Cancel failed");
    }
  };

  const handleRefund = async (id) => {
    try {
      const res = await API.post(`/orders/${id}/refund`);
      alert(res.data.message);
      window.location.reload();
    } catch {
      alert("❌ Refund failed");
    }
  };

  const handleSubmitRating = async () => {
    if (!rating) return alert("Please select a rating before submitting.");

    try {
      await API.post("/submit-rating", {
        order_id: selectedOrder.id,
        product_id: selectedOrder.pid,
        user_id: selectedOrder.user_id,
        rating,
        comment,
      });
      alert("✅ Thanks for your feedback!");
      setShowRating(false);
      setOrders((prev) =>
        prev.map((o) =>
          o.id === selectedOrder.id ? { ...o, is_rated: true } : o
        )
      );
    } catch {
      alert("❌ Failed to submit rating.");
    }
  };

  return (
    <div className="max-w-6xl mx-auto p-4 sm:p-6">
      <h2 className="text-2xl font-bold mb-6 text-gray-800">My Orders</h2>

      {orders.length === 0 ? (
        <p className="text-center text-gray-600">You haven't placed any orders yet.</p>
      ) : (
        <div className="space-y-6">
          {orders.map((order) => {
            const statusLabel = getStatusLabel(order.status, order.created_at);
            const progress = getProgressSteps(order.status);

            return (
              <div key={order.id} className="border rounded-lg bg-white shadow-sm hover:shadow-md transition">
                <div className="flex flex-col md:flex-row p-4 gap-4 md:items-center">
                  {/* Left: Product Info */}
                  <Link to={`/order/${order.id}`} className="flex flex-1 gap-4 items-center">
                    <img
                      src={`http://127.0.0.1:8000/storage/${order.product?.image}`}
                      alt={order.product?.name}
                      className="w-24 h-24 object-cover border rounded"
                    />
                    <div>
                      <h3 className="font-semibold text-lg text-gray-800">{order.product?.name}</h3>
                      <p className="text-sm text-gray-500 mt-1">
                        Ordered on{" "}
                        {new Date(order.created_at).toLocaleDateString("en-GB", {
                          day: "numeric",
                          month: "short",
                          year: "numeric",
                        })}
                      </p>
                      {order.size && <p className="text-sm text-gray-600">Size: {order.size}</p>}
                      <p className="font-medium text-gray-700 mt-1">₹{order.price}</p>
                      <p className="text-sm font-medium text-indigo-600 mt-2">{statusLabel}</p>

                      {/* Progress bar */}
                      <div className="mt-2">
                        <div className="flex items-center space-x-2">
                          {progress.map((step, idx) => (
                            <div key={idx} className="flex items-center">
                              <div
                                className={`w-3 h-3 rounded-full ${step.completed ? "bg-green-600" : "bg-gray-300"}`}
                              ></div>
                              {idx < progress.length - 1 && (
                                <div
                                  className={`w-12 h-1 mx-1 ${
                                    progress[idx + 1].completed ? "bg-green-500" : "bg-gray-300"
                                  }`}
                                ></div>
                              )}
                            </div>
                          ))}
                        </div>
                        <div className="flex justify-between text-xs text-gray-500 mt-1">
                          {progress.map((step, idx) => (
                            <span key={idx} className="w-16 text-center">{step.label}</span>
                          ))}
                        </div>
                      </div>
                    </div>
                  </Link>

                  {/* Right: Buttons */}
                  <div className="flex flex-col items-end gap-2">
                    {order.invoice_path && (
                      <a
                        href={`http://127.0.0.1:8000/storage/${order.invoice_path}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="bg-indigo-600 text-white px-4 py-1.5 text-sm rounded hover:bg-indigo-700"
                      >
                        Invoice
                      </a>
                    )}

                    {order.status === "pending" && (
                      <button
                        onClick={() => retryPayment(order)}
                        className="bg-orange-500 text-white px-4 py-1.5 text-sm rounded hover:bg-orange-600"
                      >
                        Retry Payment
                      </button>
                    )}

                    {order.status === "paid" && (
                      <button
                        onClick={() => handleCancel(order.id)}
                        className="bg-red-600 text-white px-4 py-1.5 text-sm rounded hover:bg-red-700"
                      >
                        Cancel Order
                      </button>
                    )}


{order.status === "delivered" && (
  <div className="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
    {/* Request Refund Button */}
    <button
      onClick={() => handleRefund(order.id)}
      className="border border-red-500 text-red-500 hover:bg-red-50 px-4 py-2 text-sm font-medium rounded transition-colors duration-200"
    >
      Request Refund
    </button>

    {/* Rate Product Button */}
    {!order.is_rated ? (
      <button
        onClick={() => {
          setSelectedOrder(order);
          setShowRating(true);
          setRating(0);
          setComment("");
        }}
        className="border border-gray-500 text-gray-700 hover:bg-gray-100 px-4 py-2 text-sm font-medium rounded transition-colors duration-200"
      >
        Rate Product
      </button>
    ) : (
      <span className="text-green-600 text-sm font-medium px-2 py-2">✔️ Rated</span>
    )}
  </div>
)}

                  </div>
                </div>
              </div>
            );
          })}
        </div>
      )}

      {/* Rating Modal */}
      {showRating && selectedOrder && (
        <div className="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
          <div className="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 className="text-lg font-bold mb-4">Rate {selectedOrder.product?.name}</h3>

            <div className="flex space-x-2 text-2xl mb-4">
              {[1, 2, 3, 4, 5].map((star) => (
                <button
                  key={star}
                  onClick={() => setRating(star)}
                  className={`cursor-pointer ${star <= rating ? "text-yellow-400" : "text-gray-300"}`}
                >
                  ★
                </button>
              ))}
            </div>

            <textarea
              value={comment}
              onChange={(e) => setComment(e.target.value)}
              rows={3}
              className="w-full border border-gray-300 rounded p-2 mb-4 text-sm"
              placeholder="Write your review here..."
            ></textarea>

            <div className="flex justify-end space-x-3">
              <button
                onClick={() => setShowRating(false)}
                className="text-gray-600 hover:underline"
              >
                Cancel
              </button>
              <button
                onClick={handleSubmitRating}
                className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
