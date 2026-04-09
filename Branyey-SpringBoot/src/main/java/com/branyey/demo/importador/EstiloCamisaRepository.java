package com.branyey.demo.importador;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface EstiloCamisaRepository extends JpaRepository<EstiloCamisa, Long> {
	Optional<EstiloCamisa> findByNombre(String nombre);
}
