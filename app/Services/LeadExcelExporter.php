<?php

namespace App\Services;

use RuntimeException;
use ZipArchive;

class LeadExcelExporter
{
    public function stream(array $data): void
    {
        if (! class_exists(ZipArchive::class)) {
            throw new RuntimeException('The PHP zip extension is required to export Excel files.');
        }

        $path = tempnam(sys_get_temp_dir(), 'aislagratis-lead-');

        if ($path === false) {
            throw new RuntimeException('Unable to create a temporary Excel file.');
        }

        $archive = new ZipArchive;
        if ($archive->open($path, ZipArchive::OVERWRITE) !== true) {
            unlink($path);

            throw new RuntimeException('Unable to initialize the Excel workbook.');
        }

        $entries = [
            '[Content_Types].xml' => $this->contentTypes(),
            '_rels/.rels' => $this->rootRelationships(),
            'xl/workbook.xml' => $this->workbook(),
            'xl/_rels/workbook.xml.rels' => $this->workbookRelationships(),
            'xl/styles.xml' => $this->styles(),
            'xl/worksheets/sheet1.xml' => $this->worksheet($data),
        ];

        foreach ($entries as $name => $contents) {
            if (! $archive->addFromString($name, $contents)) {
                $archive->close();
                unlink($path);

                throw new RuntimeException("Unable to add [{$name}] to the Excel workbook.");
            }
        }

        if (! $archive->close()) {
            unlink($path);

            throw new RuntimeException('Unable to finalize the Excel workbook.');
        }

        try {
            if (readfile($path) === false) {
                throw new RuntimeException('Unable to stream the Excel workbook.');
            }
        } finally {
            unlink($path);
        }
    }

    private function worksheet(array $data): string
    {
        $rows = [
            '<row r="1" ht="28" customHeight="1"><c r="A1" s="1" t="inlineStr"><is><t>Campo</t></is></c><c r="B1" s="1" t="inlineStr"><is><t>Respuesta</t></is></c></row>',
        ];

        $row = 2;
        foreach ($data as $label => $value) {
            $rows[] = '<row r="'.$row.'">'.
                $this->cell('A', $row, (string) $label).
                $this->cell('B', $row, (string) ($value ?? '')).
                '</row>';
            $row++;
        }

        $lastRow = $row - 1;

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'.
            '<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'.
            '<cols><col min="1" max="1" width="30" customWidth="1"/><col min="2" max="2" width="64" customWidth="1"/></cols>'.
            '<sheetData>'.implode('', $rows).'</sheetData>'.
            '<autoFilter ref="A1:B'.$lastRow.'"/>'.
            '</worksheet>';
    }

    private function cell(string $column, int $row, string $value): string
    {
        $escaped = htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');

        return '<c r="'.$column.$row.'" t="inlineStr"><is><t xml:space="preserve">'.$escaped.'</t></is></c>';
    }

    private function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'.
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'.
            '<Default Extension="xml" ContentType="application/xml"/>'.
            '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'.
            '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'.
            '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'.
            '</Types>';
    }

    private function rootRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'.
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'.
            '</Relationships>';
    }

    private function workbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'.
            '<sheets><sheet name="Solicitud" sheetId="1" r:id="rId1"/></sheets>'.
            '</workbook>';
    }

    private function workbookRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'.
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'.
            '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'.
            '</Relationships>';
    }

    private function styles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'.
            '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><color rgb="FFFFFFFF"/><sz val="11"/><name val="Calibri"/></font></fonts>'.
            '<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF1B5E20"/><bgColor indexed="64"/></patternFill></fill></fills>'.
            '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'.
            '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'.
            '<cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf><xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="center"/></xf></cellXfs>'.
            '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'.
            '</styleSheet>';
    }
}
