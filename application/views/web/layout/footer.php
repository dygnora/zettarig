<style>
    .footer-neon {
        border-top: 3px solid #0d6efd; /* Warna Neon Biru */
        box-shadow: 0 -10px 20px rgba(13, 110, 253, 0.2);
    }
    .hover-glow:hover {
        text-shadow: 0 0 10px #fff;
        color: #fff !important;
        transition: 0.3s;
    }
</style>

<footer class="footer-neon bg-black text-white py-5 mt-5 pixel-font">
    <div class="container text-center">
        <h4 class="fw-bold mb-3" style="letter-spacing: 2px;">ZETTARIG</h4>
        
        <div class="mb-4">
            <a href="#" class="text-decoration-none text-secondary hover-glow mx-2">Home</a>
            <a href="#" class="text-decoration-none text-secondary hover-glow mx-2">Shop</a>
            <a href="#" class="text-decoration-none text-secondary hover-glow mx-2">Support</a>
        </div>

        <p class="small text-secondary mb-0">
            © <?= date('Y'); ?> ZETTARIG — <span class="text-primary">PRESS START TO CONTINUE</span>
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>