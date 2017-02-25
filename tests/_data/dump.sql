CREATE TABLE workout_exercises (exercise_id INT AUTO_INCREMENT NOT NULL, nthInWorkout INT NOT NULL, exerciseId_exerciseId VARCHAR(255) NOT NULL, exerciseTypeId_exerciseTypeId VARCHAR(255) NOT NULL, workoutId_workoutId VARCHAR(255) NOT NULL, PRIMARY KEY(exercise_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE exercise_types (exercise_type_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, exerciseTypeId_exerciseTypeId VARCHAR(255) NOT NULL, PRIMARY KEY(exercise_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE workouts (workout_id INT AUTO_INCREMENT NOT NULL, workoutId_workoutId VARCHAR(255) NOT NULL, time_start DATETIME NOT NULL, time_end DATETIME NOT NULL, PRIMARY KEY(workout_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
