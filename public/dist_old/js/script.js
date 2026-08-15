(() => {
	const chatMessages = document.querySelector(".chat-messages"),
		chatInput = document.querySelector(".chat-input input"),
		chatToggles = document.querySelectorAll(".chat-toggle"),
		sendBtn = document.querySelector(".chat-input button");

	function toggleChat() {
		const chat = document.getElementById("chatWindow");
		chat.style.display = chat.style.display === "flex" ? "none" : "flex";
	}

	function sendMessage() {
		const messageText = chatInput.value.trim();

		if (messageText !== "") {
			// 1. Display User Message
			const userDiv = document.createElement("div");
			userDiv.classList.add("msg", "sent");
			userDiv.textContent = messageText;
			chatMessages.appendChild(userDiv);

			// Clear input and scroll to bottom
			chatInput.value = "";
			chatMessages.scrollTop = chatMessages.scrollHeight;

			// 2. Wait 1 second, then show University Response
			setTimeout(() => {
				const botDiv = document.createElement("div");
				botDiv.classList.add("msg", "received");
				botDiv.textContent = "Please wait while we process your enquiry.";
				chatMessages.appendChild(botDiv);

				// Scroll to bottom again
				chatMessages.scrollTop = chatMessages.scrollHeight;
			}, 1000);
		}
	}

	// Listen for chat initiate or chat close button press
	chatToggles.forEach((chatToggle) => {
		chatToggle.addEventListener("click", () => {
			toggleChat();
		});
	});
	// Listen for "Enter" key press
	chatInput.addEventListener("keypress", (event) => {
		if (event.key === "Enter") {
			sendMessage();
		}
	});
	// Listen for chat send button press
	sendBtn.addEventListener("click", () => {
		sendMessage();
	});
})();
