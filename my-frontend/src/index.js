import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { ProductProvider } from "./context/ProductContext";
import { CartProvider } from "./context/CartContext";
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { WishlistProvider } from "./context/WishlistContext";

// ✅ Declare it BEFORE render
const queryClient = new QueryClient();

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  <React.StrictMode>
    <ProductProvider>
      <CartProvider>
        <WishlistProvider> {/* ✅ Wrap here */}
          <QueryClientProvider client={queryClient}>
            <App />
          </QueryClientProvider>
        </WishlistProvider>
      </CartProvider>
    </ProductProvider>
  </React.StrictMode>
);

reportWebVitals();
