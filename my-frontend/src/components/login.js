import {  useState } from "react";
import { useNavigate } from "react-router-dom";
import API from "../api";

export default function Login({ onLogin }) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    setError(""); // clear previous errors
    API.post("/login", { email, password })
      .then((res) => {
        localStorage.setItem("token", res.data.access_token);
        onLogin(res.data.access_token);
        navigate("/");
      })
     .catch((err) => {
  if (err.response && err.response.status === 401) {
    // Laravel usually returns: { message: "Invalid credentials" }
    setError(err.response.data.message || "Email or password incorrect. Please try again.");
  } else if (err.response && err.response.status === 404) {
    setError("User not found. Please register an account first.");
  } else {
    setError("Server error — please try again in a few minutes.");
  }
});

  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 className="text-2xl font-bold mb-4 text-center">Login</h2>
        {error && <p className="text-red-600 mb-3 text-center">{error}</p>}
        <form onSubmit={handleSubmit} className="space-y-4">
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
            className="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
          >
            Login
          </button>
        </form>
        <p className="mt-4 text-center text-sm">
          Don&apos;t have an account?{" "}
          <a href="/register" className="text-blue-600 hover:underline">
            Register
          </a>
        </p>
      </div>
    </div>
  );
}
