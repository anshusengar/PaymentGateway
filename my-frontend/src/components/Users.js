import { useEffect, useState } from "react";
import API from "../api";

export default function User() {
  const [users, setUsers] = useState([]);

  const loadUsers = () => {
    API.get("/users")
      .then((res) => setUsers(res.data.data))
      .catch((err) => console.error(err.response));
  };

  useEffect(() => {
    loadUsers();
  }, []);

  return (
    <div>
      <h2>All Users</h2>
      {users.length ? (
        <ul>
          {users.map((u) => (
            <li key={u.id}>
              {u.name} ({u.email})
            </li>
          ))}
        </ul>
      ) : (
        <p>No users found.</p>
      )}
    </div>
  );
}
