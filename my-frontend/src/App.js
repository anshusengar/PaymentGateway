import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useEffect, useState } from "react";
import Login from "./components/login";
import Register from "./components/register";
import HomePage from "./pages/HomePage";
import Users from "./components/Users";
import ProductDetail from "./components/ProductDetail";
import Header from "./components/Header";
import axios from "axios";
import Checkout from "./pages/Checkout";
import CategoryProducts from './pages/CategoryProducts';
import CartPage from "./pages/CartPage";
import WishlistPage from "./pages/WishlistPage";
import SearchResults from "./pages/SearchResults";
import MyOrders from "./pages/Myorders";
import OrderDetail from "./pages/OrderDetail";
export default function App() {
  const [token, setToken] = useState(localStorage.getItem("token") || "");
  const [user, setUser] = useState(null);

  // get user data when token changes
  useEffect(() => {
    if (token) {
      axios
        .get("http://127.0.0.1:8000/api/user", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          setUser(res.data);
        })
        .catch(() => {
          // token invalid
          setToken("");
          localStorage.removeItem("token");
        });
    }
  }, [token]);

  const handleLogin = (newToken) => {
    localStorage.setItem("token", newToken);
    setToken(newToken);
  };

  const handleLogout = () => {
    localStorage.removeItem("token");
    setToken("");
    setUser(null);
  };

  return (
    <BrowserRouter>
      {/* header always visible */}
      <Header user={user} onLogout={handleLogout} />
      <div className="pt-10">
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route
            path="/login"
            element={<Login onLogin={handleLogin} />}
          />
          <Route path="/register" element={<Register />} />
          {token && <Route path="/users" element={<Users />} />}
          <Route path="/product/:id" element={<ProductDetail />} />
          <Route path="/search" element={<SearchResults />} />
          <Route path="/checkout/:id" element={<Checkout />} />
         <Route path="/my-orders" element={<MyOrders />} />
<Route path="/category/:id" element={<CategoryProducts />} />
<Route path="/cart" element={<CartPage />} />
<Route path="/wishlist" element={<WishlistPage />} />
<Route path="/order/:id" element={<OrderDetail />} />

        </Routes>
      </div>
     
    </BrowserRouter>
    
  );
}
