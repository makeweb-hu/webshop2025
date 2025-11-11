

<?=$html?>


<?php if ($print_mode ?? null): ?>

    <script>
        window.print();
    </script>

    <style>

            @page {
                margin: 0;
            }

            td > img {
                width: 150px !important;
            }

            * {
                padding: 0 !important;
            }

            .x-gmail-data-detectors {
                display: none;
            }

    </style>

<?php endif; ?>
