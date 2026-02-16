function bookRoom(room_id) {
    console.log("Booking room:", room_id);

    fetch("../api/book_room.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "room_id=" + room_id
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
    })
    .catch(err => {
        console.error(err);
        alert("Error occurred");
    });
}
