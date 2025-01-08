import "./bootstrap";
import React from "react";
import ReactDOM from "react-dom/client";
import Edit2 from "./components/edit2";

// Add this console log to verify the script is running
console.log("React script loaded");

// Add this to verify the element exists
const editElement = document.getElementById("edit2");
console.log("Edit element found:", editElement);

if (editElement) {
    const root = ReactDOM.createRoot(editElement);
    root.render(
        <React.StrictMode>
            <Edit2 />
        </React.StrictMode>
    );
}
