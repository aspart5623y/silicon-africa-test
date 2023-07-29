<?php


function pagination(string $path, int $currentPage, int $perPage, int $lastPage, int $total): array
{
    $links = [];
    $visiblePages = 6; // Set the number of visible paginations
    $halfVisible = (int) floor($visiblePages / 2);

    array_push($links, [
        "label" => "&laquo; previous",
        'url' => $currentPage > 1 ? $path . '?page=' . ($currentPage - 1) : null,
        "active" => false
    ]);

    // Generate paginations with ellipsis
    if ($lastPage <= $visiblePages) {
        // Display all pages if there are fewer pages than the visible limit
        $start = 1;
        $end = $lastPage;
    } elseif ($currentPage <= $halfVisible) {
        // Display pages starting from 1 to the visible limit
        $start = 1;
        $end = $visiblePages;
    } elseif ($currentPage >= ($lastPage - $halfVisible)) {
        // Display pages near the last page
        $start = $lastPage - $visiblePages + 1;
        $end = $lastPage;
    } else {
        // Display pages around the current page
        $start = $currentPage - $halfVisible;
        $end = $currentPage + $halfVisible;
    }

    // Generate paginations
    for ($i = $start; $i <= $end; $i++) {
        array_push($links, [
            "label" => $i,
            'url' => $path . "?page=$i",
            "active" => $currentPage == $i,
        ]);
    }

    // Add ellipsis if necessary
    if ($start > 1) {
        array_splice($links, 1, 0, [
            [
                "label" => '...',
                'url' => null,
                "active" => false
            ]
        ]);
    }
    if ($end < $lastPage) {
        array_splice($links, -1, 0, [
            [
                "label" => '...',
                'url' => null,
                "active" => false
            ]
        ]);
    }

    array_push($links, [
        "label" => "next &raquo;",
        'url' => $currentPage < $lastPage ? $path . '?page=' . ($currentPage + 1) : null,
        "active" => false
    ]);

    $from = $total > 0 ? ($currentPage - 1) * $perPage + 1 : 0;
    $to = min($from + $perPage - 1, $total);

    return [
        $from,
        $to,
        $links
    ];
}
