package com.branyey.demo.importador;

import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.ss.usermodel.Sheet;
import org.apache.poi.ss.usermodel.Workbook;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.io.InputStream;
import java.util.Arrays;
import java.util.HashSet;
import java.util.Locale;
import java.util.Set;

@RestController
@RequestMapping("/api/import")
public class ImportController {
    @Autowired ClasificacionTallaRepository clasificacionTallaRepository;
    @Autowired ColorRepository colorRepository;
    @Autowired TallaRepository tallaRepository;
    @Autowired EstiloCamisaRepository estiloCamisaRepository;

    private static final Set<String> CLASIFICACIONES_VALIDAS =
        new HashSet<>(Arrays.asList("Niño", "Dama", "Adulto"));

    @PostMapping("/{tabla}")
    public ResponseEntity<?> importar(@PathVariable String tabla, @RequestParam("file") MultipartFile file) {
        try (InputStream is = file.getInputStream()) {
            String tablaNormalizada = tabla.trim().toLowerCase(Locale.ROOT);
            if (!Arrays.asList("clasificacion-talla", "colores", "tallas", "estilos-camisa").contains(tablaNormalizada)) {
                return ResponseEntity.badRequest().body("Tabla no soportada");
            }

            try (Workbook workbook = new XSSFWorkbook(is)) {
                Sheet sheet = workbook.getSheetAt(0);
                DataFormatter formatter = new DataFormatter();

                if (sheet.getPhysicalNumberOfRows() <= 1) {
                    return ResponseEntity.badRequest().body("El archivo no tiene filas de datos.");
                }

                int procesadas = 0;

                for (Row row : sheet) {
                    if (row.getRowNum() == 0) continue; // Saltar encabezado

                    String nombre = textoDeCelda(row.getCell(0), formatter);
                    if (nombre.isBlank()) {
                        continue;
                    }

                    switch (tablaNormalizada) {
                        case "clasificacion-talla":
                            if (!CLASIFICACIONES_VALIDAS.contains(nombre)) {
                                return ResponseEntity.badRequest().body("Clasificación no válida en fila " + (row.getRowNum() + 1) + ". Usa: Niño, Dama o Adulto.");
                            }
                            ClasificacionTalla ct = clasificacionTallaRepository.findByNombre(nombre).orElseGet(ClasificacionTalla::new);
                            ct.setNombre(nombre);
                            clasificacionTallaRepository.save(ct);
                            procesadas++;
                            break;
                        case "colores":
                            Color color = colorRepository.findByNombre(nombre).orElseGet(Color::new);
                            color.setNombre(nombre);
                            if (color.getActivo() == null) {
                                color.setActivo(true);
                            }

                            String codigoHex = textoDeCelda(row.getCell(1), formatter);
                            color.setCodigoHex(codigoHex.isBlank() ? null : codigoHex);
                            colorRepository.save(color);
                            procesadas++;
                            break;
                        case "tallas":
                            String clasificacionNombre = textoDeCelda(row.getCell(1), formatter);
                            if (clasificacionNombre.isBlank()) {
                                return ResponseEntity.badRequest().body("Falta clasificación en fila " + (row.getRowNum() + 1) + " de tallas.");
                            }

                            ClasificacionTalla clasificacion = clasificacionTallaRepository
                                .findByNombre(clasificacionNombre)
                                .orElseThrow(() -> new IllegalArgumentException("La clasificación '" + clasificacionNombre + "' no existe para la fila " + (row.getRowNum() + 1) + "."));

                            Talla talla = tallaRepository
                                .findByNombreAndClasificacion_Id(nombre, clasificacion.getId())
                                .orElseGet(Talla::new);
                            talla.setNombre(nombre);
                            talla.setClasificacion(clasificacion);
                            if (talla.getActivo() == null) {
                                talla.setActivo(true);
                            }
                            tallaRepository.save(talla);
                            procesadas++;
                            break;
                        case "estilos-camisa":
                            EstiloCamisa estilo = estiloCamisaRepository.findByNombre(nombre).orElseGet(EstiloCamisa::new);
                            estilo.setNombre(nombre);
                            if (estilo.getActivo() == null) {
                                estilo.setActivo(true);
                            }
                            estiloCamisaRepository.save(estilo);
                            procesadas++;
                            break;
                        default:
                            return ResponseEntity.badRequest().body("Tabla no soportada");
                    }
                }

                return ResponseEntity.ok("Importación exitosa. Registros procesados: " + procesadas);
            }
        } catch (Exception e) {
            return ResponseEntity.status(500).body("Error: " + e.getMessage());
        }
    }

    private String textoDeCelda(Cell cell, DataFormatter formatter) {
        if (cell == null) {
            return "";
        }
        return formatter.formatCellValue(cell).trim();
    }
}
