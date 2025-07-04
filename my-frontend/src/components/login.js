import { useState } from "react";
import { useNavigate } from "react-router-dom"; 
import API from "../api";

export default function Login({ onLogin }) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
 const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    API.post("/login", { email, password })
      .then((res) => {
        localStorage.setItem("token", res.data.access_token);
        onLogin(res.data.access_token);
         navigate("/");
      })
      .catch(() => setError("Invalid credentials"));
  };

  return (
    <div>
      <h2>Login</h2>
      <form onSubmit={handleSubmit}>
        <input
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        /><br/>
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        /><br/>
        <button type="submit">Login</button>
        {error && <p style={{ color: "red" }}>{error}</p>}
      </form>
    </div>
  );
}
