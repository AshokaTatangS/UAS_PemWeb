let deleteFormId = null;

// Menampilkan modal konfirmasi
function showConfirmationModal(id, nim) {
    deleteFormId = id;
    const modal = document.getElementById("confirmation-modal");
    const message = document.getElementById("confirmation-message");
    message.innerHTML = `Apakah Anda yakin ingin menghapus data dengan NIM <b>${nim}</b>?`;
    modal.style.display = "flex";
}

// Menutup modal konfirmasi
function closeConfirmationModal() {
    const modal = document.getElementById("confirmation-modal");
    modal.style.display = "none";
}

// Menampilkan modal edit
function showEditModal(id, name, nim, major, address) {
    document.getElementById("edit-id").value = id;
    document.getElementById("name").value = name;
    document.getElementById("nim").value = nim;
    document.getElementById("major").value = major;
    document.getElementById("address").value = address;

    const modal = document.getElementById("edit-modal");
    modal.style.display = "flex";
}

// Menutup modal edit
function closeEditModal() {
    const modal = document.getElementById("edit-modal");
    modal.style.display = "none";
}