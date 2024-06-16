const express = require("express");
const { SocketAddress } = require("net");
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

  socket.on("gudang-data-change", () => {
    console.log("gudang data change");
    io.emit("gudang-data-change");
  });

  socket.on("ukur-data-change", () => {
    console.log("ukur data change");
    io.emit("ukur-data-change");
  });

  socket.on("disconnect", () => {
    console.log("socket disconnected");
  });
});
