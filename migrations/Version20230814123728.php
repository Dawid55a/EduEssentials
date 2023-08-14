<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230814123728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE attendance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE grade_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subject_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE teacher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE attendance (id INT NOT NULL, student_id INT NOT NULL, lesson_id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DE30D91CB944F1A ON attendance (student_id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91CDF80196 ON attendance (lesson_id)');
        $this->addSql('CREATE TABLE course (id INT NOT NULL, homeroom_teacher_id INT NOT NULL, grade INT NOT NULL, sufix VARCHAR(16) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_169E6FB929738B85 ON course (homeroom_teacher_id)');
        $this->addSql('CREATE TABLE grade (id INT NOT NULL, student_id INT NOT NULL, teacher_id INT NOT NULL, test_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, weight INT NOT NULL, assign_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, change_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_595AAE34CB944F1A ON grade (student_id)');
        $this->addSql('CREATE INDEX IDX_595AAE3441807E1D ON grade (teacher_id)');
        $this->addSql('CREATE INDEX IDX_595AAE341E5D0459 ON grade (test_id)');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, start_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subject (id INT NOT NULL, subject_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE teacher (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE teacher_subject (teacher_id INT NOT NULL, subject_id INT NOT NULL, PRIMARY KEY(teacher_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_360CB33B41807E1D ON teacher_subject (teacher_id)');
        $this->addSql('CREATE INDEX IDX_360CB33B23EDC87 ON teacher_subject (subject_id)');
        $this->addSql('CREATE TABLE test (id INT NOT NULL, subject_id INT NOT NULL, teacher_id INT NOT NULL, course_id INT NOT NULL, datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, topic VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D87F7E0C23EDC87 ON test (subject_id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0C41807E1D ON test (teacher_id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0C591CC992 ON test (course_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB929738B85 FOREIGN KEY (homeroom_teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3441807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE341E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_subject ADD CONSTRAINT FK_360CB33B41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_subject ADD CONSTRAINT FK_360CB33B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE attendance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE grade_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subject_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE teacher_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('ALTER TABLE attendance DROP CONSTRAINT FK_6DE30D91CB944F1A');
        $this->addSql('ALTER TABLE attendance DROP CONSTRAINT FK_6DE30D91CDF80196');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB929738B85');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE34CB944F1A');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE3441807E1D');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE341E5D0459');
        $this->addSql('ALTER TABLE teacher_subject DROP CONSTRAINT FK_360CB33B41807E1D');
        $this->addSql('ALTER TABLE teacher_subject DROP CONSTRAINT FK_360CB33B23EDC87');
        $this->addSql('ALTER TABLE test DROP CONSTRAINT FK_D87F7E0C23EDC87');
        $this->addSql('ALTER TABLE test DROP CONSTRAINT FK_D87F7E0C41807E1D');
        $this->addSql('ALTER TABLE test DROP CONSTRAINT FK_D87F7E0C591CC992');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE teacher_subject');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
