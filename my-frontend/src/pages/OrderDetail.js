import { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";
import API from "../api";

export default function OrderDetail() {
  const { id } = useParams();
  const [order, setOrder] = useState(null);
  const [showCancelModal, setShowCancelModal] = useState(false);
  const [showRefundModal, setShowRefundModal] = useState(false);
  const [reason, setReason] = useState("");

  useEffect(() => {
    API.get(`/orders/${id}`)
      .then((res) => setOrder(res.data))
      .catch(() => console.error("Order not found"));
  }, [id]);

  if (!order) return <p className="text-center mt-10">Loading...</p>;

  const { product } = order;

  const statusColors = {
    pending: "bg-yellow-100 text-yellow-700",
    paid: "bg-green-100 text-green-700",
    delivered: "bg-blue-100 text-blue-700",
    cancelled: "bg-red-100 text-red-700",
    refunded: "bg-purple-100 text-purple-700",
  };

  const handleAction = async (type) => {
    try {
      const url = `/orders/${order.id}/${type}`;
      const res = await API.post(url, { reason });

      alert(res.data.message);
      setOrder((prev) => ({
        ...prev,
        status: type === "cancel" ? "cancelled" : "refunded",
      }));

      setShowCancelModal(false);
      setShowRefundModal(false);
      setReason("");
    } catch (err) {
      alert(`${type === "cancel" ? "Cancel" : "Refund"} failed`);
    }
  };

  return (
    <div className="max-w-4xl mx-auto p-6 relative">
      <h2 className="text-2xl font-bold mb-6 text-gray-800">Order Summary</h2>

      {/* Progress bar like Myntra */}
      <div className="flex justify-between items-center mb-6 px-4">
        {["Ordered", "Shipped", "Delivered"].map((stage, i) => {
          const active =
            stage === "Ordered" ||
            (stage === "Shipped" && order.status !== "pending") ||
            (stage === "Delivered" && order.status === "delivered");

          return (
            <div key={stage} className="text-center flex-1 relative">
              <div
                className={`mx-auto w-4 h-4 rounded-full ${
                  active ? "bg-green-500" : "bg-gray-300"
                }`}
              ></div>
              <p
                className={`text-sm mt-2 ${
                  active ? "text-green-600" : "text-gray-500"
                }`}
              >
                {stage}
              </p>
              {i < 2 && (
                <div className="absolute top-2 left-1/2 w-full h-0.5 bg-gray-300 -z-10">
                  <div
                    className={`h-0.5 ${
                      active ? "bg-green-500" : "bg-gray-300"
                    } w-full`}
                  ></div>
                </div>
              )}
            </div>
          );
        })}
      </div>

      {/* Product Card */}
      <div className="bg-white border rounded-lg shadow p-6 flex gap-6 mb-6">
        <img
          src={`http://127.0.0.1:8000/storage/${product.image}`}
          alt={product.name}
          className="w-32 h-32 object-cover rounded"
        />
        <div className="flex-1">
          <h3 className="text-lg font-bold text-gray-800">{product.name}</h3>
          <p className="text-sm text-gray-600">{product.brand}</p>
          <p className="mt-2 text-sm text-gray-700">
            ₹{order.price} &middot; Size: {order.size || "N/A"}
          </p>
          <p className="mt-2 text-sm">
            Status:{" "}
            <span
              className={`px-2 py-1 rounded text-xs font-medium ${
                statusColors[order.status] || "bg-gray-200 text-gray-700"
              }`}
            >
              {order.status.toUpperCase()}
            </span>
          </p>

          {order.invoice_path && (
            <a
              href={`http://127.0.0.1:8000/storage/${order.invoice_path}`}
              target="_blank"
              className="mt-4 inline-block text-sm text-indigo-600 underline"
            >
              📄 Download Invoice
            </a>
          )}

          {(order.status === "paid" || order.status === "pending") && (
            <div className="mt-4 flex gap-4">
              {order.status === "paid" && (
                <button
                  onClick={() => setShowRefundModal(true)}
                  className="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                >
                  Request Refund
                </button>
              )}
              {order.status === "pending" && (
                <button
                  onClick={() => setShowCancelModal(true)}
                  className="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                >
                  Cancel Order
                </button>
              )}
            </div>
          )}
        </div>
      </div>

      {/* Address */}
      <div className="bg-gray-50 p-4 rounded border">
        <h4 className="text-lg font-semibold mb-2">Shipping Address</h4>
        <p className="text-sm">
          {order.name} <br />
         {order.city}, {order.state} - {order.pincode} <br />
          Phone: {order.phone}
        </p>
      </div>

      <Link to="/my-orders" className="text-indigo-600 mt-4 block">
        ← Back to My Orders
      </Link>

      {/* Cancel Modal */}
      {showCancelModal && (
        <Modal
          title="Cancel Order"
          onClose={() => setShowCancelModal(false)}
          onConfirm={() => handleAction("cancel")}
          reason={reason}
          setReason={setReason}
        />
      )}

      {/* Refund Modal */}
      {showRefundModal && (
        <Modal
          title="Request Refund"
          onClose={() => setShowRefundModal(false)}
          onConfirm={() => handleAction("refund")}
          reason={reason}
          setReason={setReason}
        />
      )}
    </div>
  );
}

function Modal({ title, onClose, onConfirm, reason, setReason }) {
  return (
    <div className="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">
      <div className="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
        <h3 className="text-lg font-semibold mb-4">{title}</h3>
        <label className="text-sm font-medium mb-1 block">Select Reason</label>
        <select
          value={reason}
          onChange={(e) => setReason(e.target.value)}
          className="w-full border rounded p-2 mb-4"
        >
          <option value="">-- Select --</option>
          <option value="Changed my mind">Changed my mind</option>
          <option value="Ordered by mistake">Ordered by mistake</option>
          <option value="Product delayed">Product delayed</option>
          <option value="Other">Other</option>
        </select>

        <div className="flex justify-end gap-3">
          <button
            onClick={onClose}
            className="px-4 py-2 bg-gray-200 text-gray-700 rounded"
          >
            Close
          </button>
          <button
            onClick={onConfirm}
            className="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
            disabled={!reason}
          >
            Confirm
          </button>
        </div>
      </div>
    </div>
  );
}
