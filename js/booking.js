function bookRoom(roomId) {
    fetch("../api/book_room.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "room_id=" + roomId
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("book-msg").innerText = data;
        if (data.includes("sent")) {
            setTimeout(() => location.reload(), 800);
        }
    });
}
