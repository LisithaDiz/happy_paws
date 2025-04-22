<?php

class Report
{
    use Controller;

    public function index()
    {
        // Check if pharmacy is logged in
        if (!isset($_SESSION['pharmacy_id'])) {
            header("Location: " . ROOT . "/login");
            exit();
        }

        $pharmacy_id = $_SESSION['pharmacy_id'];
        
        try {
            // Get date range from request, default to current month
            $start_date = $_GET['start_date'] ?? date('Y-m-01');
            $end_date = $_GET['end_date'] ?? date('Y-m-t');

            // Get report data
            $order = new Order();
            
            // Get sales summary
            $sales_data = $order->getSalesReport($pharmacy_id, $start_date, $end_date);
            if (!$sales_data) {
                $sales_data = (object)[
                    'total_orders' => 0,
                    'total_revenue' => 0,
                    'average_order_value' => 0,
                    'accepted_orders' => 0,
                    'declined_orders' => 0,
                    'paid_orders' => 0,
                    'pending_payments' => 0
                ];
            }
            
            // Get medicine sales details
            $medicine_sales = $order->getMedicineSalesReport($pharmacy_id, $start_date, $end_date);
            if (!$medicine_sales) {
                $medicine_sales = [];
            }

            $data = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'sales_summary' => $sales_data,
                'medicine_sales' => $medicine_sales
            ];

            $this->view('report', $data);
        } catch (Exception $e) {
            error_log("Error generating report: " . $e->getMessage());
            $_SESSION['error'] = "Error generating report. Please try again.";
            header("Location: " . ROOT . "/pharmacydashboard");
            exit();
        }
    }

    public function download()
    {
        // Check if pharmacy is logged in
        if (!isset($_SESSION['pharmacy_id'])) {
            header("Location: " . ROOT . "/login");
            exit();
        }

        $pharmacy_id = $_SESSION['pharmacy_id'];
        
        try {
            $start_date = $_GET['start_date'] ?? date('Y-m-01');
            $end_date = $_GET['end_date'] ?? date('Y-m-t');

            $order = new Order();
            $sales_data = $order->getSalesReport($pharmacy_id, $start_date, $end_date);
            if (!$sales_data) {
                $sales_data = (object)[
                    'total_orders' => 0,
                    'total_revenue' => 0,
                    'average_order_value' => 0,
                    'accepted_orders' => 0,
                    'declined_orders' => 0,
                    'paid_orders' => 0,
                    'pending_payments' => 0
                ];
            }
            
            $medicine_sales = $order->getMedicineSalesReport($pharmacy_id, $start_date, $end_date);
            if (!$medicine_sales) {
                $medicine_sales = [];
            }

            // Set headers for CSV download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="medicine_sales_report_' . date('Y-m-d') . '.csv"');
            
            // Create a file pointer connected to PHP output
            $output = fopen('php://output', 'w');
            
            // Set column headers
            fputcsv($output, ['Medicine Name', 'Orders', 'Quantity Sold', 'Revenue']);
            
            // Add data rows
            foreach ($medicine_sales as $medicine) {
                fputcsv($output, [
                    $medicine->med_name,
                    $medicine->order_count,
                    $medicine->total_quantity,
                    number_format($medicine->total_revenue, 2)
                ]);
            }
            
            // Close the file pointer
            fclose($output);
            
            exit();
        } catch (Exception $e) {
            error_log("Error downloading report: " . $e->getMessage());
            $_SESSION['error'] = "Error downloading report. Please try again.";
            header("Location: " . ROOT . "/report");
            exit();
        }
    }
} 