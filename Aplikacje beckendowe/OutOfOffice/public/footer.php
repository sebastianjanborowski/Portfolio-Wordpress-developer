<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/app-form-utils.js"></script>
    <script src="../js/app-navigation.js"></script>

    <?php if (!empty($pageScript)): ?>
        <script src="../js/<?php echo htmlspecialchars($pageScript, ENT_QUOTES, 'UTF-8'); ?>"></script>
    <?php endif; ?>
</body>
</html>
