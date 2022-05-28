<?php

    namespace imdmedia\Data;

    use imdmedia\Data\DB;

    use PDO;


    class Report {
        private $reporting_user;
        private $reported_user;

        public function getReporting_user()
        {
                return $this->reporting_user;
        }

        public function setReporting_user($reporting_user)
        {
                $this->reporting_user = $reporting_user;

                return $this;
        }

        public function getReported_user()
        {
                return $this->reported_user;
        }

        public function setReported_user($reported_user)
        {
                $this->reported_user = $reported_user;

                return $this;
        }

        public function reportUser() {

            $conn = DB::getConnection();
            $statement = $conn->prepare("INSERT INTO reports (reporting_user, reported_user) VALUES (:reporting_user, :reported_user)");
            $statement->bindValue(":reporting_user", $this->reporting_user);
            $statement->bindValue(":reported_user", $this->reported_user);
            $statement->execute();

        }

        public function unreportUser() {

            $conn = DB::getConnection();
            $statement = $conn->prepare("DELETE FROM reports WHERE reporting_user = :reporting_user AND reported_user = :reported_user");
            $statement->bindValue(":reporting_user", $this->reporting_user);
            $statement->bindValue(":reported_user", $this->reported_user);
            $statement->execute();

        }

        public static function getReportCount($user) {

            $conn = DB::getConnection();
            $statement = $conn->prepare("SELECT * FROM reports WHERE reported_user = :reported_user");
            $statement->bindValue(":reported_user", $user);
            $statement->execute();
            $rowcount = $statement->rowCount();

            return $rowcount;

        }

        public static function getReportedUsers($user) {

            $conn = DB::getConnection();
            $statement = $conn->prepare("SELECT * FROM reports WHERE reporting_user = :reporting_user");
            $statement->bindValue(":reporting_user", $user);
            $statement->execute();
            $ReportedUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $ReportedUsers;
           
        }

        public static function checkReport($user, $profile) {
            $user;
            $profile;
            $conn = DB::getConnection();
            $statement = $conn->prepare("SELECT * FROM reports WHERE reporting_user = :reporting_user AND reported_user = :reported_user");
            $statement->bindValue(":reporting_user", $user);
            $statement->bindValue(":reported_user", $profile);
            $statement->execute();
            $rowcount = $statement->rowCount();

            if($rowcount > 0) {
                return true;
            } else {
                return false;
            }

        }
    }