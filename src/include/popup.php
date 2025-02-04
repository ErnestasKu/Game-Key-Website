<!-- POPUP -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-button" onclick="closePopup()">&times;</span>
        <p id="popup-message"></p>
    </div>
</div>

<script>
    // no more resubmit form
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    window.onclick = function (event) {
        const popup = document.getElementById('popup');
        if (event.target == popup) {
            closePopup();
        }
    };

    function showPopup(message) {
        const popup = document.getElementById('popup');
        const popupMessage = document.getElementById('popup-message');
        popupMessage.textContent = message;
        popup.style.display = 'flex';
    }

    // function closePopup() {
    //     const popup = document.getElementById('popup');
    //     popu
    //     p.style.display = 'none';
    // }

    function closePopup() {
        const popup = document.getElementById('popup');
        popup.style.display = 'none';
    }
</script>