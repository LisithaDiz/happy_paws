<?php

class Revenue
{
    use Controller;

    public function index()
    {
        // Create the data array first
        $revenue_data = [
            'summary' => [
                'total_revenue' => 124500,
                'monthly_average' => 10375,
                'top_product' => [
                    'name' => 'Paracetamol',
                    'units' => 1245
                ]
            ],
            'monthly_revenue' => [
                [
                    'month' => 'March 2024',
                    'revenue' => 12500,
                    'orders' => 450,
                    'top_product' => 'Antibiotics',
                    'growth' => 5.2
                ],
                [
                    'month' => 'February 2024',
                    'revenue' => 11200,
                    'orders' => 425,
                    'top_product' => 'Pain Relief',
                    'growth' => 3.1
                ],
                [
                    'month' => 'January 2024',
                    'revenue' => 10800,
                    'orders' => 390,
                    'top_product' => 'Vitamins',
                    'growth' => -1.5
                ],
                [
                    'month' => 'December 2023',
                    'revenue' => 13500,
                    'orders' => 520,
                    'top_product' => 'Cold Medicine',
                    'growth' => 8.4
                ],
                [
                    'month' => 'November 2023',
                    'revenue' => 11900,
                    'orders' => 445,
                    'top_product' => 'Supplements',
                    'growth' => 2.8
                ]
            ],
            'top_products' => [
                [
                    'name' => 'Paracetamol',
                    'units_sold' => 1245,
                    'revenue' => 6225,
                    'profit_margin' => 35
                ],
                [
                    'name' => 'Vitamin C',
                    'units_sold' => 980,
                    'revenue' => 4900,
                    'profit_margin' => 45
                ],
                [
                    'name' => 'Antibiotics',
                    'units_sold' => 756,
                    'revenue' => 15120,
                    'profit_margin' => 30
                ],
                [
                    'name' => 'Pain Relief Gel',
                    'units_sold' => 645,
                    'revenue' => 9675,
                    'profit_margin' => 40
                ],
                [
                    'name' => 'First Aid Kit',
                    'units_sold' => 423,
                    'revenue' => 8460,
                    'profit_margin' => 25
                ]
            ]
        ];

        // Calculate statistics
        $revenue_data['statistics'] = [
            'total_orders' => array_sum(array_column($revenue_data['monthly_revenue'], 'orders')),
            'average_growth' => round(array_sum(array_column($revenue_data['monthly_revenue'], 'growth')) / count($revenue_data['monthly_revenue']), 2),
            'average_margin' => round(array_sum(array_column($revenue_data['top_products'], 'profit_margin')) / count($revenue_data['top_products']), 2)
        ];

        // Pass the data to the view
        $this->view('revenue', [
            'data' => $revenue_data
        ]);
    }
}