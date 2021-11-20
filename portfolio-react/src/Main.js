import React from 'react';
import styles from './Main.module.css';

function Main() {
  return (
    <div className={styles.main}>
        <div className={styles.container}>
            <div className={styles.greeting}>
                <span>Привет!</span>
                <span>Меня зовут Шрамко Алексей</span>
                <span>Я - front-end разработчик</span>
            </div>
            <div className={styles.photo}>
                <img src="#" alt=""/>
            </div>
        </div>
    </div>
  );
}

export default Main;
