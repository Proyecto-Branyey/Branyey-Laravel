package com.branyey.demo.importador;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface ClasificacionTallaRepository extends JpaRepository<ClasificacionTalla, Long> {
	Optional<ClasificacionTalla> findByNombre(String nombre);
}
