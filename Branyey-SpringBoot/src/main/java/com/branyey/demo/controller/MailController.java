package com.branyey.demo.controller;

import com.branyey.demo.dto.EmailRequest;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/mail")
public class MailController {

    @Autowired
    private JavaMailSender mailSender;


    @PostMapping("/send")
    public String sendMail(@RequestBody EmailRequest request) {
        SimpleMailMessage message = new SimpleMailMessage();
        // El remitente se toma del usuario configurado en spring.mail.username
        message.setTo(request.getTo());
        message.setSubject(request.getSubject());
        message.setText(request.getBody());
        mailSender.send(message);
        return "Correo enviado correctamente";
    }
}
