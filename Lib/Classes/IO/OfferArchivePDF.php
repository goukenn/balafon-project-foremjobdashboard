<?php
// @author: C.A.D. BONDJE DOUE
// @file: IO/OfferArchivePDF.php
// @desc: FPDF based document used to build the merged offers archive.
//        One font family (Helvetica) everywhere, same layout for every offer.
//        FPDF core fonts are cp1252: text is converted from UTF-8 with txt().
// @date: 20261020
namespace com\igkdev\projects\ForemJobDashboard\IO;

/**
 * requires the FPDF library (loaded by igk_require_module(Modules::igk_pdflib()))
 * @package com\igkdev\projects\ForemJobDashboard\IO
 * @author C.A.D. BONDJE DOUE
 */
class OfferArchivePDF extends \FPDF
{
    const FONT = 'Helvetica';
    const MARGIN = 18;
    const LABEL_WIDTH = 45;
    private $m_footer;

    public function __construct(string $footer)
    {
        parent::__construct('P', 'mm', 'A4');
        $this->m_footer = $footer;
        $this->SetMargins(self::MARGIN, 16, self::MARGIN);
        $this->SetAutoPageBreak(true, 16);
        $this->AliasNbPages();
        $this->SetCreator('Forem Jobs Dashboard');
    }
    /**
     * convert UTF-8 to the cp1252 charset used by the core fonts
     */
    public static function txt(?string $s): string
    {
        $s = (string)$s;
        $r = @iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', $s);
        return $r === false ? $s : $r;
    }
    public function Footer()
    {
        $this->SetY(-12);
        $this->SetFont(self::FONT, '', 7);
        $this->SetTextColor(128);
        $this->Cell(0, 5, self::txt($this->m_footer), 0, 0, 'L');
        $this->SetX(self::MARGIN);
        $this->Cell(0, 5, 'page ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
    protected function heading(string $text, int $size = 11)
    {
        $this->Ln(4);
        $this->SetFont(self::FONT, 'B', $size);
        $this->SetTextColor(0);
        $this->MultiCell(0, 6, self::txt($text));
        $this->Ln(1);
    }
    protected function body(?string $text)
    {
        $this->SetFont(self::FONT, '', 9);
        $this->SetTextColor(0);
        $this->MultiCell(0, 4.6, self::txt($text));
    }
    /**
     * add one offer section (starts on a new page)
     * @param array $o title, enterprise, id, ref, date, from, status, docs[], description, response
     */
    public function addOffer(array $o)
    {
        $this->AddPage();
        $this->SetFont(self::FONT, 'B', 15);
        $this->SetTextColor(0);
        $this->MultiCell(0, 7, self::txt($o['title'] . ' - ' . $o['enterprise']));
        $this->SetFont(self::FONT, '', 8);
        $this->SetTextColor(100);
        $this->Cell(0, 5, self::txt('Fiche Forem Jobs #' . $o['id'] . ($o['ref'] ? ' - ref. ' . $o['ref'] : '')), 0, 1);
        $this->Ln(2);
        $rows = [
            'Entreprise' => $o['enterprise'],
            "Date d'enregistrement" => $o['date'],
            'Source (De)' => $o['from'],
            'Statut' => $o['status'],
            'Documents sur la fiche' => $o['docs'] ? implode(' + ', $o['docs']) : 'aucun',
        ];
        $w = $this->GetPageWidth() - 2 * self::MARGIN - self::LABEL_WIDTH;
        foreach ($rows as $k => $v) {
            $this->SetFont(self::FONT, '', 8);
            $this->SetTextColor(100);
            $this->Cell(self::LABEL_WIDTH, 6, self::txt($k), 'B', 0);
            $this->SetFont(self::FONT, '', 9);
            $this->SetTextColor(0);
            $this->Cell($w, 6, self::txt($v), 'B', 1);
        }
        $this->heading("Description de l'offre");
        $this->body($o['description'] ?: "(description non disponible sur la fiche)");
        if ($o['docs'] || $o['response']) {
            $this->heading('Documents liés à la candidature');
            foreach ($o['docs_info'] as $line) {
                $this->body($line);
            }
            if ($o['response']) {
                $this->Ln(2);
                $this->SetFont(self::FONT, 'B', 9);
                $this->Cell(0, 5, self::txt('Réponse :'), 0, 1);
                $this->body($o['response']);
            }
        }
    }
}
