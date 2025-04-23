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
            
            // Get monthly revenue details
            $revenue = new RevenueModel();
            $revenue->createMonthlyRevenueTable();
            $revenue->updateMonthlyRevenue($pharmacy_id);
            $monthly_revenue = $revenue->getMonthlyRevenueDetails($pharmacy_id);
            if (!$monthly_revenue) {
                $monthly_revenue = [];
            }

            $data = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'sales_summary' => $sales_data,
                'medicine_sales' => $medicine_sales,
                'monthly_revenue' => $monthly_revenue
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
            
            // Get monthly revenue details
            $revenue = new RevenueModel();
            $revenue->createMonthlyRevenueTable();
            $revenue->updateMonthlyRevenue($pharmacy_id);
            $monthly_revenue = $revenue->getMonthlyRevenueDetails($pharmacy_id);
            if (!$monthly_revenue) {
                $monthly_revenue = [];
            }

            // Include TCPDF library
            require_once($_SERVER['DOCUMENT_ROOT'] . '/happy_paws/app/libraries/tcpdf/tcpdf/tcpdf.php');

            // Create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('Happy Paws Pharmacy');
            $pdf->SetAuthor('Happy Paws Pharmacy');
            $pdf->SetTitle('Sales Report');

            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set default monospaced font
            $pdf->SetDefaultMonospacedFont('courier');

            // Set margins
            $pdf->SetMargins(15, 15, 15);

            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);

            // Add a page
            $pdf->AddPage();

            // Set font
            $pdf->SetFont('helvetica', 'B', 24);
            
            // Add logo and title
            $pdf->SetTextColor(248, 126, 118); // Theme color
            $pdf->Cell(0, 20, 'HAPPY PAWS PHARMACY', 0, 1, 'C');
            
            // Add subtitle
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetTextColor(51, 51, 51); // Dark gray
            $pdf->Cell(0, 10, 'Sales Report', 0, 1, 'C');
            
            // Add date range
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetTextColor(102, 102, 102); // Medium gray
            $pdf->Cell(0, 10, 'Period: ' . date('d M Y', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($end_date)), 0, 1, 'C');
            $pdf->Ln(10);

            // Summary Section
            $pdf->SetFillColor(248, 126, 118); // Theme color
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(0, 10, 'Summary', 1, 1, 'C', true);
            $pdf->Ln(5);

            // Summary content
            $pdf->SetTextColor(51, 51, 51);
            $pdf->SetFont('helvetica', 'B', 12);
            $summary = array(
                'Total Orders' => number_format($sales_data->total_orders),
                'Total Revenue' => 'Rs. ' . number_format($sales_data->total_revenue, 2),
                'Average Order Value' => 'Rs. ' . number_format($sales_data->average_order_value, 2),
                'Completed Orders' => number_format($sales_data->paid_orders)
            );

            foreach($summary as $key => $value) {
                $pdf->Cell(60, 10, $key . ':', 0, 0, 'L');
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(0, 10, $value, 0, 1, 'L');
                $pdf->SetFont('helvetica', 'B', 12);
            }
            $pdf->Ln(10);

            // Medicine Sales Section
            $pdf->SetFillColor(248, 126, 118);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(0, 10, 'Medicine Sales Details', 1, 1, 'C', true);
            $pdf->Ln(5);

            // Table header
            $pdf->SetFillColor(248, 126, 118);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(80, 10, 'Medicine Name', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'Orders', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Quantity Sold', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Revenue', 1, 1, 'C', true);

            // Table data
            $pdf->SetFont('helvetica', '', 11);
            $pdf->SetTextColor(51, 51, 51);
            $rowCount = 0;
            foreach($medicine_sales as $medicine) {
                if ($rowCount % 2 == 0) {
                    $pdf->SetFillColor(245, 245, 245);
                } else {
                    $pdf->SetFillColor(255, 255, 255);
                }
                $pdf->Cell(80, 10, $medicine->med_name, 1, 0, 'L', true);
                $pdf->Cell(30, 10, number_format($medicine->order_count), 1, 0, 'R', true);
                $pdf->Cell(40, 10, number_format($medicine->total_quantity), 1, 0, 'R', true);
                $pdf->Cell(40, 10, 'Rs. ' . number_format($medicine->total_revenue, 2), 1, 1, 'R', true);
                $rowCount++;
            }
            $pdf->Ln(10);

            // Monthly Revenue Section
            $pdf->SetFillColor(248, 126, 118);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(0, 10, 'Monthly Revenue Details', 1, 1, 'C', true);
            $pdf->Ln(5);

            // Table header
            $pdf->SetFillColor(248, 126, 118);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(40, 10, 'Month', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Revenue', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'Orders', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Top Product', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Growth', 1, 1, 'C', true);

            // Table data
            $pdf->SetFont('helvetica', '', 11);
            $pdf->SetTextColor(51, 51, 51);
            $rowCount = 0;
            foreach($monthly_revenue as $month) {
                if ($rowCount % 2 == 0) {
                    $pdf->SetFillColor(245, 245, 245);
                } else {
                    $pdf->SetFillColor(255, 255, 255);
                }
                $pdf->Cell(40, 10, $month['month'], 1, 0, 'L', true);
                $pdf->Cell(40, 10, 'Rs. ' . number_format($month['revenue'], 2), 1, 0, 'R', true);
                $pdf->Cell(30, 10, number_format($month['orders']), 1, 0, 'R', true);
                $pdf->Cell(40, 10, $month['top_product'], 1, 0, 'L', true);
                
                // Color code the growth percentage
                $growth = $month['growth'];
                if ($growth >= 0) {
                    $pdf->SetTextColor(40, 167, 69); // Green for positive growth
                } else {
                    $pdf->SetTextColor(220, 53, 69); // Red for negative growth
                }
                $pdf->Cell(40, 10, number_format($growth, 2) . '%', 1, 1, 'R', true);
                $pdf->SetTextColor(51, 51, 51);
                $rowCount++;
            }

            // Add footer
            $pdf->Ln(10);
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->SetTextColor(102, 102, 102);
            $pdf->Cell(0, 10, 'Generated on: ' . date('d M Y H:i:s'), 0, 1, 'C');
            $pdf->Cell(0, 10, 'Happy Paws Pharmacy - Your Trusted Pet Care Partner', 0, 1, 'C');

            // Output the PDF
            $pdf->Output('sales_report.pdf', 'D');
            
        } catch (Exception $e) {
            error_log("Error downloading report: " . $e->getMessage());
            $_SESSION['error'] = "Error downloading report. Please try again.";
            header("Location: " . ROOT . "/report");
            exit();
        }
    }
} 