package com.branyey.demo.importador;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface TallaRepository extends JpaRepository<Talla, Long> {
	Optional<Talla> findByNombreAndClasificacion_Id(String nombre, Long clasificacionId);
}
