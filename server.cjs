const express = require("express");
const app = express();

const server = require("http").createServer(app);
const io = require("socket.io")(server, {
  cors: {
    origin: "*",
  },
});

server.listen(3000, () => {
  console.log("listen on :3000");
});

io.on("connection", (socket) => {
  console.log("socket connected");

  socket.on("input-bikin-seragam", (seragam) => {
    io.emit("update-data-seragam", seragam);
  });

  socket.on("disconnect", () => {
    console.log("socket disconnected");
  });
});
