package com.branyey.demo.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.core.io.InputStreamSource;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;

import jakarta.mail.MessagingException;
import jakarta.mail.internet.MimeMessage;
import java.util.Base64;

@Service
public class MailService {
    @Autowired
    private JavaMailSender mailSender;

    @Value("${spring.mail.from}")
    private String senderEmail;

    /**
     * Envía un correo simple que puede ser HTML o texto plano
     * Detecta automáticamente si es HTML por las etiquetas <
     */
    public void sendSimpleMail(String to, String subject, String body) {
        try {
            MimeMessage message = mailSender.createMimeMessage();
            MimeMessageHelper helper = new MimeMessageHelper(message, false, "UTF-8");
            
            helper.setFrom(senderEmail);
            helper.setTo(to);
            helper.setSubject(subject);
            
            // En este microservicio los correos se envían en formato HTML
            helper.setText(body, true);
            
            mailSender.send(message);
        } catch (Exception e) {
            throw new RuntimeException("Error enviando correo simple: " + e.getMessage(), e);
        }
    }

    /**
     * Envía un correo con adjunto (PDF, imágenes, etc.)
     * El archivo se recibe en base64 para evitar problemas de serialización
     * También soporta HTML en el cuerpo del mensaje
     */
    public void sendMailWithAttachment(String to, String subject, String body, 
                                       String attachmentBase64, String attachmentName) throws MessagingException {
        try {
            MimeMessage message = mailSender.createMimeMessage();
            MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");
            
            helper.setFrom(senderEmail);
            helper.setTo(to);
            helper.setSubject(subject);
            
            // En este microservicio los correos se envían en formato HTML
            helper.setText(body, true);
            
            // Decodificar base64 a bytes
            byte[] decodedAttachment = Base64.getDecoder().decode(attachmentBase64);
            InputStreamSource attachment = new ByteArrayResource(decodedAttachment);
            helper.addAttachment(attachmentName, attachment);
            
            mailSender.send(message);
        } catch (Exception e) {
            throw new RuntimeException("Error enviando correo con adjunto: " + e.getMessage(), e);
        }
    }
}
