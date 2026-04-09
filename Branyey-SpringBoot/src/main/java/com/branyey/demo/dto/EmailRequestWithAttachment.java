package com.branyey.demo.dto;

public class EmailRequestWithAttachment {
    private String to;
    private String subject;
    private String body;
    private String attachmentBase64;
    private String attachmentName;

    public EmailRequestWithAttachment() {}

    public String getTo() { return to; }
    public void setTo(String to) { this.to = to; }

    public String getSubject() { return subject; }
    public void setSubject(String subject) { this.subject = subject; }

    public String getBody() { return body; }
    public void setBody(String body) { this.body = body; }

    public String getAttachmentBase64() { return attachmentBase64; }
    public void setAttachmentBase64(String attachmentBase64) { this.attachmentBase64 = attachmentBase64; }

    public String getAttachmentName() { return attachmentName; }
    public void setAttachmentName(String attachmentName) { this.attachmentName = attachmentName; }
}
