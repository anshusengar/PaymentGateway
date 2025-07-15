import { createContext, useState, useEffect } from "react";
import API from "../api";  // assuming you have your local API for loading products

export const ProductContext = createContext();

export const ProductProvider = ({ children }) => {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    // load once
    API.get("/products")
      .then((res) => setProducts(res.data.data || res.data))
      .catch((err) => console.error("Could not load products", err));
  }, []);

  return (
    <ProductContext.Provider value={{ products }}>
      {children}
    </ProductContext.Provider>
  );
};
