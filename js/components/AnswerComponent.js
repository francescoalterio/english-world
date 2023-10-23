import { $, element } from "../tools.js";

export function AnswerComponent({ $container, wordData }) {
  const $resultContainer = element("div");
  const $pWord = element("p");
  const $pUserTranslate = element("p");
  const $pTranslate = element("p");
  const $button = element("button");
  const $status = element("div");

  $button.classList.add("primary-button");

  $pWord.classList.add("p-answer");
  $pUserTranslate.classList.add("p-answer");
  $pTranslate.classList.add("p-answer");
  $resultContainer.classList.add("answer-container");

  $pWord.innerHTML = `Word: <span class="result-word">${wordData.word}</span>`;
  $pUserTranslate.innerHTML = `Your Translation: <span class="user-translation">${wordData["user-translation"]}</span>`;
  $pTranslate.innerHTML = `Translation: <span class="translation">${wordData.translate}</span>`;
  $button.textContent = "Next Word";
  $button.setAttribute("type", "submit");

  const userTranslatioIsCorrect = wordData["user-translation-is-correct"];

  $status.classList.add("answer-status");

  userTranslatioIsCorrect
    ? $status.classList.add("answer-status-true")
    : $status.classList.add("answer-status-false");

  $status.innerHTML = userTranslatioIsCorrect
    ? `<svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
</svg>`
    : `<svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
  </svg>`;

  $resultContainer.append($pWord, $pUserTranslate, $pTranslate);

  $container.append($resultContainer, $status, $button);
}
