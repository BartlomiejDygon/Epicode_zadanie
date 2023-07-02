import React from 'react';
import ReactDOM from "react-dom/client";
import List from "../component/List";

const root = ReactDOM.createRoot(document.getElementById("jobOffer"));
root.render(
    <React.StrictMode>
        <List />
    </React.StrictMode>
);