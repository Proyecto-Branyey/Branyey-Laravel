package com.branyey.demo.importador;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface ColorRepository extends JpaRepository<Color, Long> {
	Optional<Color> findByNombre(String nombre);
}
