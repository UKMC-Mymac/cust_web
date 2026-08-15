<?php

namespace App\Services;

class BreadcrumbService
{
    /**
     * Generate breadcrumb data from trail configuration
     * 
     * @param string $trail - the trail key (e.g., 'events.show')
     * @param array $data - additional data (current_label, etc.)
     * @return array
     */
    public static function generate($trail, $data = [])
    {
        $config = config('breadcrumbs');
        $trailConfig = $config['trails'][$trail] ?? null;

        if (!$trailConfig) {
            return ['showBreadcrumb' => false];
        }

        $breadcrumbs = [];
        
        foreach ($trailConfig['breadcrumbs'] as $crumb) {
            if ($crumb === 'current') {
                // Last item (current page) - not clickable
                $breadcrumbs[] = [
                    'label' => $data['current_label'] ?? 'Page',
                    'url' => '#'
                ];
            } else {
                // Regular link from config
                $link = $config['links'][$crumb] ?? null;
                if ($link) {
                    $breadcrumbs[] = [
                        'label' => $link['label'],
                        'url' => route($link['route'])
                    ];
                }
            }
        }

        return [
            'showBreadcrumb' => true,
            'breadcrumbTitle' => $data['title'] ?? $trailConfig['title'],
            'breadcrumbs' => $breadcrumbs
        ];
    }
}
