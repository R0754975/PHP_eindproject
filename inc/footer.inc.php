<footer>
            <div class="pageCounter">
                <?php for ($page = 1; $page <= $pageCount; $page++): ?>
                    <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>          
            </div>
</footer>