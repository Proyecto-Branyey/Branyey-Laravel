package com.branyey.demo.controller;

import com.branyey.demo.dto.EmailRequest;
import com.branyey.demo.dto.EmailRequestWithAttachment;
import com.branyey.demo.service.MailService;
import jakarta.mail.MessagingException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/mail")
public class MailController {

    @Autowired
    private MailService mailService;

    @PostMapping("/send")
    public String sendMail(@RequestBody EmailRequest request) {
        try {
            mailService.sendSimpleMail(request.getTo(), request.getSubject(), request.getBody());
            return "Correo enviado correctamente";
        } catch (Exception e) {
            return "Error: " + e.getMessage();
        }
    }

    @PostMapping("/send-with-attachment")
    public ResponseEntity<String> sendMailWithAttachment(@RequestBody EmailRequestWithAttachment request) {
        try {
            mailService.sendMailWithAttachment(
                request.getTo(),
                request.getSubject(),
                request.getBody(),
                request.getAttachmentBase64(),
                request.getAttachmentName()
            );
            return ResponseEntity.ok("Correo con adjunto enviado correctamente");
        } catch (MessagingException e) {
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR)
                .body("Error enviando correo con adjunto: " + e.getMessage());
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST)
                .body("Error: " + e.getMessage());
        }
    }
}
