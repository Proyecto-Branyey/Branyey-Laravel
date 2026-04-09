package com.branyey.demo.importador;

import jakarta.persistence.*;

@Entity
@Table(name = "estilos_camisa")
public class EstiloCamisa {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false, unique = true, length = 100)
    private String nombre;

    @Column(nullable = false)
    private Boolean activo = true;

    public Long getId() { return id; }

    public void setId(Long id) { this.id = id; }

    public String getNombre() { return nombre; }

    public void setNombre(String nombre) { this.nombre = nombre; }

    public Boolean getActivo() { return activo; }

    public void setActivo(Boolean activo) { this.activo = activo; }
}
