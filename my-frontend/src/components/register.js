import { useState } from "react";
import API from "../api";
import { useNavigate } from "react-router-dom";

export default function Register() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const [error, setError] = useState("");

  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    setError("");
    setMessage("");

    API.post("/register", { name, email, password })
      .then(() => {
        setMessage("Registration successful! Please login.");
        setName("");
        setEmail("");
        setPassword("");
        setTimeout(() => {
          navigate("/login");
        }, 2000);
      })
      .catch((err) => {
        if (err.response && err.response.data && err.response.data.message) {
          setError(err.response.data.message);
        } else {
          setError("Registration failed. Please try again.");
        }
      });
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 className="text-2xl font-bold mb-4 text-center">Register</h2>
        {message && (
          <p className="text-green-600 mb-3 text-center">{message}</p>
        )}
        {error && (
          <p className="text-red-600 mb-3 text-center">{error}</p>
        )}
        <form onSubmit={handleSubmit} className="space-y-4">
          <input
            className="w-full border rounded px-3 py-2"
            placeholder="Name"
            value={name}
            onChange={(e) => setName(e.target.value)}
            required
          />
          <input
            className="w-full border rounded px-3 py-2"
            placeholder="Email"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
          <input
            className="w-full border rounded px-3 py-2"
            placeholder="Password"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
          <button
            type="submit"
            className="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
          >
            Register
          </button>
        </form>
        <p className="mt-4 text-center text-sm">
          Already have an account?{" "}
          <a href="/login" className="text-blue-600 hover:underline">
            Login here
          </a>
        </p>
      </div>
    </div>
  );
}
