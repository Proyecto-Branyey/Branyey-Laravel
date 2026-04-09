package com.branyey.demo.importador;

import jakarta.persistence.*;

@Entity
@Table(name = "tallas")
public class Talla {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false, length = 10)
    private String nombre;

    @ManyToOne(optional = false)
    @JoinColumn(name = "clasificacion_id", nullable = false)
    private ClasificacionTalla clasificacion;

    @Column(nullable = false)
    private Boolean activo = true;

    public Long getId() { return id; }

    public void setId(Long id) { this.id = id; }

    public String getNombre() { return nombre; }

    public void setNombre(String nombre) { this.nombre = nombre; }

    public ClasificacionTalla getClasificacion() { return clasificacion; }

    public void setClasificacion(ClasificacionTalla clasificacion) { this.clasificacion = clasificacion; }

    public Boolean getActivo() { return activo; }

    public void setActivo(Boolean activo) { this.activo = activo; }
}
