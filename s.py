import tkinter as tk
from tkinter import filedialog, messagebox

# Dictionary to store offsets and field details
FIELDS = {
    "Rupees (Money)": {"offset": 0x0048, "length": 2, "max": 999},
    "Heart Containers": {"offset": 0x0042, "length": 2, "max": 40},  # Stored in quarter hearts
    "Health": {"offset": 0x0044, "length": 2, "max": 40},  # Stored in quarter hearts
    "Magic Meter": {"offset": 0x004A, "length": 1, "options": ["None", "Small", "Large"]},
    "Wallet Size": {"offset": 0x004C, "length": 1, "max": 3},  # Determines rupee capacity
}

# Function to read data from a save file
def read_save_file(file_path, offset, length):
    try:
        with open(file_path, "rb") as file:
            file.seek(offset)
            data = file.read(length)
            return int.from_bytes(data, byteorder="big")
    except Exception as e:
        messagebox.showerror("Error", f"Failed to read file: {e}")
        return None

# Function to write data to a save file
def write_save_file(file_path, offset, value, length):
    try:
        with open(file_path, "r+b") as file:
            file.seek(offset)
            file.write(value.to_bytes(length, byteorder="big"))
    except Exception as e:
        messagebox.showerror("Error", f"Failed to write to file: {e}")

# Open file dialog to select the save file
def open_file():
    file_path = filedialog.askopenfilename(title="Select Save File")
    if file_path:
        file_label.config(text=f"File: {file_path}")
        load_fields(file_path)
    return file_path

# Load the fields from the save file
def load_fields(file_path):
    for field, details in FIELDS.items():
        value = read_save_file(file_path, details["offset"], details["length"])
        if value is not None:
            if "options" in details:  # Dropdown
                dropdowns[field].set(details["options"][value])
            else:  # Text box
                entries[field].delete(0, tk.END)
                entries[field].insert(0, value)

# Save changes to the save file
def save_changes():
    file_path = file_label.cget("text").replace("File: ", "")
    if not file_path:
        messagebox.showerror("Error", "No file selected!")
        return

    for field, details in FIELDS.items():
        if "options" in details:  # Dropdown
            value = details["options"].index(dropdowns[field].get())
        else:  # Text box
            value = int(entries[field].get())
            if value > details["max"]:
                messagebox.showwarning("Warning", f"{field} exceeds max value ({details['max']}).")
                return

        write_save_file(file_path, details["offset"], value, details["length"])
    messagebox.showinfo("Success", "Changes saved successfully!")

# GUI Setup
root = tk.Tk()
root.title("Save File Editor")
root.geometry("400x400")

# File selection
file_label = tk.Label(root, text="No file selected", anchor="w")
file_label.pack(fill="x", padx=10, pady=5)
tk.Button(root, text="Open File", command=open_file).pack(padx=10, pady=5)

# Field entries
frame = tk.Frame(root)
frame.pack(fill="both", expand=True, padx=10, pady=10)

entries = {}
dropdowns = {}
for i, (field, details) in enumerate(FIELDS.items()):
    tk.Label(frame, text=field).grid(row=i, column=0, sticky="w", padx=5, pady=5)

    if "options" in details:  # Dropdown
        dropdown_var = tk.StringVar()
        dropdown = tk.OptionMenu(frame, dropdown_var, *details["options"])
        dropdown.grid(row=i, column=1, sticky="w", padx=5, pady=5)
        dropdowns[field] = dropdown_var
    else:  # Text box
        entry = tk.Entry(frame)
        entry.grid(row=i, column=1, sticky="w", padx=5, pady=5)
        entries[field] = entry

# Save button
tk.Button(root, text="Save Changes", command=save_changes).pack(padx=10, pady=10)

root.mainloop()