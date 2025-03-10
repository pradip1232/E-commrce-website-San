 <?php
    ob_start(); // Start output buffering

    require_once('TCPDF-main/tcpdf.php'); // Include TCPDF library

    class MYPDF extends TCPDF
    {
        public function Header()
        {
            $this->SetFont('helvetica', 'B', 14);
            $this->Cell(0, 10, 'Tax Invoice', 0, 1, 'C');
            $this->SetFont('helvetica', 'I', 10);
            $this->Cell(0, 5, '(Tax Analysis)', 0, 1, 'C');
            $this->Ln(5);
        }
    }

    $pdf = new MYPDF();
    $pdf->SetMargins(10, 20, 10);
    $pdf->AddPage();
    // Set top margin
    $pdf->SetY(10); // Moves table down by 10mm from the top



    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(95, 7, 'Invoice No: NRMC/326/24-25', 0, 0, 'L');
    $pdf->Cell(95, 7, 'Dated: 6-march-25', 0, 1, 'R');
    $pdf->Ln(3);

    // Set font
    $pdf->SetFont('helvetica', '', 10);

    // Left Side: Seller & Buyer Details
    $pdf->SetXY(10, 20); // Position to start text on left

    // Seller Details
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(90, 6, 'DIVYA JYOTI FOUNDATION', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(90, 5, "Vill-Uppal Jagir, Nakodar Road Nurmahal,\nDistt: Jalandhar, Punjab", 0, 'L');
    $pdf->Cell(90, 5, 'GSTIN/UIN: 03AABTD5493M1ZH', 0, 1, 'L');
    $pdf->Cell(90, 5, 'State Name: Punjab, Code: 03', 0, 1, 'L');
    $pdf->Ln(2);

    // Buyer Details
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(90, 6, 'Party: DIVYA JYOTI FOUNDATION', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(90, 5, "1ST FLOOR, KAPOOR BHAVAN, PARI MAHAL, KASUMPTI, SHIMLA-171009", 0, 'L');
    $pdf->Cell(90, 5, 'GSTIN/UIN: 02AABTD5493M1ZJ', 0, 1, 'L');
    $pdf->Cell(90, 5, 'State Name: Himachal Pradesh, Code: 02', 0, 1, 'L');

    // Right Side: Table with 2 Columns and 5 Rows
    $pdf->SetXY(110, 20); // Move to the right side

    // Set table width
    $tableWidth = 90; // Sum of column widths (45 + 45)
    $pageWidth = $pdf->GetPageWidth();
    $marginRight = 10; // Set right margin

    // Calculate X position to align table to the right
    $xPosition = $pageWidth - $tableWidth - $marginRight;

    // Set table position
    $pdf->SetX($xPosition);

    // Table Header
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(45, 8, 'Column 1', 1, 0, 'C');
    $pdf->Cell(45, 8, 'Column 2', 1, 1, 'C');

    // Table Rows
    $pdf->SetFont('helvetica', '', 9);
    for ($i = 1; $i <= 5; $i++) {
        $pdf->SetX($xPosition); // Move each row to the right position
        $pdf->Cell(45, 8, "Row $i - Data 1", 1, 0, 'C');
        $pdf->Cell(45, 8, "Row $i - Data 2", 1, 1, 'C');
    }
    // Set top margin
    // $pdf->SetY(-5); // Moves table down by 10mm from the top



    // Set top margin
    $pdf->SetY(90); // Moves table down by 10mm from the top



    // this is product details atble or main table 
    // Table Header
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(45, 7, 'Product Name & Batch No.', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'HSN/SAC', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Taxable Value', 1, 0, 'C', 1);
    $pdf->Cell(20, 7, 'IGST %', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'Tax Amount', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Total', 1, 1, 'C', 1);

    // Table Data
    $pdf->SetFont('helvetica', '', 9);
    $data = [
        ['Paracetamol', 'BATCH123', '30049011', 4621.98, '12%', 554.63, 5176.61],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Toothpaste', 'BATCH456', '33061020', 6224.64, '18%', 1120.44, 7345.08],
        ['Pain Relief', 'BATCH789', '30039022', 1176.71, '18%', 176.17, 1352.88],
        ['Shampoo', 'BATCH101', '33051090', 6223.68, '18%', 1120.26, 7343.94],
        ['Cough Syrup', 'BATCH202', '30049012', 2063.08, '12%', 247.57, 2310.65]
    ];

    $totalTaxable = 0;
    $totalGST = 0;
    $totalAmount = 0;

    foreach ($data as $row) {
        $pdf->Cell(45, 6, $row[0] . "\nBatch: " . $row[1], 1);
        $pdf->Cell(25, 6, $row[2], 1);
        $pdf->Cell(30, 6, number_format($row[3], 2), 1, 0, 'R');
        $pdf->Cell(20, 6, $row[4], 1, 0, 'R');
        $pdf->Cell(25, 6, number_format($row[5], 2), 1, 0, 'R');
        $pdf->Cell(30, 6, number_format($row[6], 2), 1, 1, 'R');

        $totalTaxable += $row[3];
        $totalGST += $row[5];
        $totalAmount += $row[6];
    }

    // Add second page
    $pdf->AddPage();

    // Repeat table header on second page
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(45, 7, 'Product Name & Batch No.', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'HSN/SAC', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Taxable Value', 1, 0, 'C', 1);
    $pdf->Cell(20, 7, 'IGST %', 1, 0, 'C', 1);
    $pdf->Cell(25, 7, 'Tax Amount', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Total', 1, 1, 'C', 1);

    $data2 = [
        ['Cooking Oil', 'BATCH303', '15149120', 1338.80, '5%', 66.94, 1405.74],
        ['Olive Oil', 'BATCH404', '15131900', 1214.20, '5%', 60.71, 1274.91],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Table Salt', 'BATCH505', '25010020', 622.48, '5%', 31.12, 653.60],
        ['Vitamins', 'BATCH606', '21606909', 822.48, '18%', 149.11, 971.59]
    ];

    foreach ($data2 as $row) {
        $pdf->Cell(45, 6, $row[0] . "\nBatch: " . $row[1], 1);
        $pdf->Cell(25, 6, $row[2], 1);
        $pdf->Cell(30, 6, number_format($row[3], 2), 1, 0, 'R');
        $pdf->Cell(20, 6, $row[4], 1, 0, 'R');
        $pdf->Cell(25, 6, number_format($row[5], 2), 1, 0, 'R');
        $pdf->Cell(30, 6, number_format($row[6], 2), 1, 1, 'R');

        $totalTaxable += $row[3];
        $totalGST += $row[5];
        $totalAmount += $row[6];
    }

    // Final Totals Row
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(45, 6, 'Total', 1, 0, 'R');
    $pdf->Cell(25, 6, '', 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($totalTaxable, 2), 1, 0, 'R');
    $pdf->Cell(20, 6, '', 1, 0, 'C');
    $pdf->Cell(25, 6, number_format($totalGST, 2), 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($totalAmount, 2), 1, 1, 'R');















    // Create new PDF document
    // $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 10);

    // Add pages
    for ($page = 1; $page <= 1; $page++) {
        $pdf->AddPage();

        // Invoice Title
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Tax Invoice', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, '(Tax Analysis)', 0, 1, 'C');
        $pdf->Ln(3);

        // Invoice Header
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(95, 8, 'Invoice No. NRMC/326/24-25', 1, 0);
        $pdf->Cell(95, 8, 'Dated 19-Feb-25', 1, 1);

        // Company Details
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(190, 8, 'DIVYA JYOTI FOUNDATION', 1, 1, 'C');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->MultiCell(190, 6, "Vill-Uppal Jagir, Nakodar Road Nurmahal, Distt-Jalandhar, Punjab\nGSTIN/UIN: 03AABTD5493M1ZH | State Name: Punjab, Code : 03", 1, 'C');
        $pdf->Ln(2);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(38, 8, 'HSN/SAC', 1, 0, 'C');
        $pdf->Cell(38, 8, 'Taxable Value', 1, 0, 'C');
        $pdf->Cell(38, 8, 'Rate', 1, 0, 'C');
        $pdf->Cell(38, 8, 'IGST Amount', 1, 0, 'C');
        $pdf->Cell(38, 8, 'Total Amount', 1, 1, 'C');

        // Table Rows
        $pdf->SetFont('helvetica', '', 9);
        $data = [
            ['30049011', '4,621.68', '12%', '554.63', '554.63'],
            ['33061020', '6,224.64', '18%', '1,120.44', '1,120.44'],
            ['33030020', '8,648.80', '18%', '1,556.78', '1,556.78'],
            ['21069011', '3,226.83', '18%', '1,120.26', '1,120.26'],
            ['33051090', '3,223.80', '18%', '1,120.26', '1,120.26'],
            ['30049011', '6,338.06', '18%', '616.90', '616.90'],
            ['15141920', '1,214.20', '5%', '60.71', '60.71'],
            ['25010020', '1,700.00', '5%', '70.00', '70.00'],
            ['21069099', '828.80', '18%', '149.11', '149.11']
        ];

        foreach ($data as $row) {
            foreach ($row as $cell) {
                $pdf->Cell(38, 8, $cell, 1, 0, 'C');
            }
            $pdf->Ln();
        }

        // Total Row
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(38, 8, '', 1, 0);
        $pdf->Cell(38, 8, '35,664.38', 1, 0, 'C');
        $pdf->Cell(38, 8, '', 1, 0);
        $pdf->Cell(38, 8, '4,320.83', 1, 0, 'C');
        $pdf->Cell(38, 8, '4,320.83', 1, 1, 'C');

        // Tax Amount in Words
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(190, 8, 'Tax Amount (in words): Four Thousand Three Hundred Twenty INR and Eighty Three Paise Only', 1, 1, 'C');
    }


    // Output the PDF
    // $pdf->Output('invoice.pdf', 'D');
    $pdf->Output(__DIR__ . '/invoice.pdf', 'F');

    // $pdf->Output($pdfPath, 'F'); // Save file to disk

    ob_end_clean(); // Clean buffer and prevent unwanted output
    ?>